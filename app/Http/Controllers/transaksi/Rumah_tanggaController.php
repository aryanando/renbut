<?php

namespace App\Http\Controllers\transaksi;

use App\Exports\ArrayExport;
use App\Http\Controllers\Controller;
use App\Imports\Rumah_tanggaImport;
use App\Models\Rumah_tangga;
use App\Models\Satuan;
use App\Models\Uraian;
use App\Models\Unit;
use Illuminate\Http\Request;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class Rumah_tanggaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $unit_id = Auth::user()->unit;
        if(!DB::table('unit_access')->where(['unit_id' => $unit_id, 'table' => 'rumah_tangga'])->exists()){
            abort(403);
        }
        $date = $request->get('periode') ?? date('Y-m-t');
        $unit = $request->get('unit') ?? $unit_id;

        $rumah_tangga = DB::select("call sp_rumah_tangga('". htmlspecialchars(date('Y-m-t', strtotime($date)))."', ?)", [$unit]);

        $uraian = Uraian::where('bagian', 'rumah_tangga')->orderby('keterangan')->get();
        $satuan = Satuan::orderby('keterangan')->get();
        $unit = Unit::leftJoin('unit_access', 'unit_access.unit_id', 'units.id')->where('table', 'rumah_tangga')->where('unit_id', '<>', 999)->orderby('keterangan')->get();

        return view('transaksi.rumah_tangga.index', compact('rumah_tangga', 'uraian', 'satuan', 'unit'));
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
        $unit_id = Auth::user()->unit;
        if(!DB::table('unit_access')->where(['unit_id' => $unit_id, 'table' => 'rumah_tangga'])->exists()){
            abort(403);
        }
        $requestData = $request->all();

        if ($requestData['jumlah'] <= 0) {
            return redirect('transaksi/rumah_tangga')->with('error_message', 'Jumlah tidak boleh kosong!');
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

        Rumah_tangga::updateOrCreate(
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
                'bagian' => 'rumah_tangga',
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

        return redirect('transaksi/rumah_tangga')->with('flash_message', 'Rumah_tangga added!');
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
        if(!DB::table('unit_access')->where(['unit_id' => $unit_id, 'table' => 'rumah_tangga'])->exists()){
            abort(403);
        }
        Rumah_tangga::destroy($id);

        return redirect('transaksi/rumah_tangga')->with('flash_message', 'Rumah_tangga deleted!');
    }

    /**
     * For Print Out
     *
     */
    public function toexcel(Request $request)
    {
        $requestData = $request->all();
        $periode = date('Y-m-t', strtotime($requestData['periode'] ?? date('Y-m-t')));

        $rumah_tangga = DB::select("call sp_to_excel('". $periode ."', 'rumah_tangga')");

        array_unshift($rumah_tangga, array_keys((array)$rumah_tangga[0]));
        $data = new ArrayExport($rumah_tangga);

        ob_end_clean(); // this
        ob_start(); // and this

        return Excel::download($data, date('Y-m').'_rumah_tangga.xlsx');

    }

    public function import(Request $request)
    {
        Excel::import(new Rumah_tanggaImport, $request->file('excel'));

        return redirect('transaksi/rumah_tangga')->with('flash_message', 'Rumah tangga imported!');
    }

}
