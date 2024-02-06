<?php

namespace App\Http\Controllers\transaksi;

use App\Exports\ArrayExport;
use App\Http\Controllers\Controller;
use App\Imports\AlkesImport;
use App\Models\Alkes;
use App\Models\Satuan;
use App\Models\Uraian;
use App\Models\Unit;
use Illuminate\Http\Request;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class AlkesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // $keyword = $request->get('search');
        $unit_id = Auth::user()->unit;
        if(!DB::table('unit_access')->where(['unit_id' => $unit_id, 'table' => 'alkes'])->exists()){
            abort(403);
        }
        $date = $request->get('periode') ?? date('Y-m-t');
        $unit = $request->get('unit') ?? $unit_id;
        // $perPage = 25;

        // if (!empty($keyword)) {
        //     $alkes = Alkes::where('user_id', 'LIKE', "%$keyword%")
        //         ->orWhere('periode', 'LIKE', "%$keyword%")
        //         ->orWhere('uraian', 'LIKE', "%$keyword%")
        //         ->orWhere('satuan', 'LIKE', "%$keyword%")
        //         ->orWhere('unit_id', 'LIKE', "%$keyword%")
        //         ->orWhere('jumlah', 'LIKE', "%$keyword%")
        //         ->orWhere('harga', 'LIKE', "%$keyword%")
        //         ->orWhere('total', 'LIKE', "%$keyword%")
        //         ->orWhere('keterangan', 'LIKE', "%$keyword%")
        //         ->orderby('uraian')->paginate($perPage);
        // } else {
        //     $alkes = Alkes::orderby('uraian')->paginate($perPage);
        // }

        $alkes = DB::select("call sp_alkes('". htmlspecialchars(date('Y-m-t', strtotime($date)))."', ?)", [$unit]);

        $uraian = Uraian::where('bagian', 'alkes')->orderby('keterangan')->get();
        $satuan = Satuan::orderby('keterangan')->get();
        $unit = Unit::leftJoin('unit_access', 'unit_access.unit_id', 'units.id')->where('table', 'alkes')->where('unit_id', '<>', 999)->orderby('keterangan')->get();

        return view('transaksi.alkes.index', compact('alkes', 'uraian', 'satuan', 'unit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $uraian = Uraian::where('bagian', 'alkes')->get();
        $satuan = Satuan::get();

        return view('transaksi.alkes.create', compact('uraian', 'satuan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // if($tglmulai > $today > $tglselesai){
        //     return  "tgl penginputan renbut belum di mulai"
        // }
        // elseif($tglmulai > $today > $tglselesai){
        //     return  "tgl penginputan renbut sudah selesai"
        // }
        $requestData = $request->all();

        if ($requestData['jumlah'] <= 0) {
            return redirect('transaksi/alkes')->with('error_message', 'Jumlah tidak boleh kosong!');
        }
        if (empty(str_replace(' ', '', $requestData['uraian']))) {
            return redirect('transaksi/alkes')->with('error_message', 'Uraian tidak boleh kosong!');
        }

        $unit_id = Auth::user()->unit;
        $requestData['periode'] = date('Y-m-t');
        $requestData['user_id'] = Auth::user()->id;
        $requestData['unit_id'] = $unit_id;
        $requestData['uraian'] = strtoupper($requestData['uraian']);
        $requestData['total'] = $requestData['jumlah'] * $requestData['harga'];
        $requestData['satuan'] = ucfirst(strtolower($requestData['satuan']));

        Alkes::updateOrCreate(
            [
                'periode' => $requestData['periode'],
                'unit_id' => $requestData['unit_id'],
                'uraian' => $requestData['uraian'],
            ],
            $requestData,
        );
        Uraian::updateOrCreate(
            [
                'keterangan' => $requestData['uraian'],
                'satuan' => $requestData['satuan'],
                'bagian' => 'alkes',
            ],
            [
                'harga' => $requestData['harga'],
            ],
        );
        Satuan::updateOrCreate(
            [
                'keterangan' => $requestData['satuan'],
            ],
            [],
        );

        return redirect('transaksi/alkes')->with('flash_message', 'Alkes added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $alkes = Alkes::findOrFail($id);

        return view('transaksi.alkes.show', compact('alkes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $alkes = Alkes::findOrFail($id);

        return view('transaksi.alkes.edit', compact('alkes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $alkes = Alkes::findOrFail($id);
        $alkes->update($requestData);

        return redirect('transaksi/alkes')->with('flash_message', 'Alkes updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $unit_id = Auth::user()->unit;
        if(!DB::table('unit_access')->where(['unit_id' => $unit_id, 'table' => 'alkes'])->exists()){
            abort(403);
        }
        Alkes::destroy($id);

        return redirect('transaksi/alkes')->with('flash_message', 'Alkes deleted!');
    }

    /**
     * For Print Out
     *
     */
    public function toexcel(Request $request)
    {
        $requestData = $request->all();
        $periode = date('Y-m-t', strtotime($requestData['periode'] ?? date('Y-m-t')));
        // $atk = Atk::where('periode', $periode)->get();
        $atk = DB::select("call sp_to_excel('". $periode ."', 'alkes')");
        // $unit = DB::table('unit_access')->leftJoin("units", "units.id" , "unit_access.unit_id")->where(['table' => 'atk'])->get();

        // dd(array_keys((array)$atk[0]));
        array_unshift($atk, array_keys((array)$atk[0]));
        $data = new ArrayExport($atk);
        // $data = new ArrayExport([
        //     [1, 2, 3],
        //     [4, 5, 6]
        // ]);

        ob_end_clean(); // this
        ob_start(); // and this

        return Excel::download($data, date('Y-m').'_alkes.xlsx');

    }

    public function import(Request $request)
    {
        // $request->hasFile('excel')
        // $path = $request->file('excel')->getRealPath();

        Excel::import(new AlkesImport, $request->file('excel'));

        return redirect('transaksi/alkes')->with('flash_message', 'Alkes imported!');
    }

}
