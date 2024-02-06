<?php

namespace App\Http\Controllers\transaksi;

use App\Exports\ArrayExport;
use App\Http\Controllers\Controller;
use App\Imports\ObatImport;
use App\Models\Obat;
use App\Models\Satuan;
use App\Models\Uraian;
use App\Models\Unit;
use Illuminate\Http\Request;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $unit_id = Auth::user()->unit;
        if(!DB::table('unit_access')->where(['unit_id' => $unit_id, 'table' => 'obat'])->exists()){
            abort(403);
        }
        $date = $request->get('periode') ?? date('Y-m-t');
        $unit = $request->get('unit') ?? $unit_id;

        $obat = DB::select("call sp_obat('". htmlspecialchars(date('Y-m-t', strtotime($date)))."', ?)", [$unit]);

        $uraian = Uraian::where('bagian', 'obat')->orderby('keterangan')->get();
        $satuan = Satuan::orderby('keterangan')->get();
        $unit = Unit::leftJoin('unit_access', 'unit_access.unit_id', 'units.id')->where('table', 'obat')->where('unit_id', '<>', 999)->orderby('keterangan')->get();

        return view('transaksi.obat.index', compact('obat', 'uraian', 'satuan', 'unit'));
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
        if(!DB::table('unit_access')->where(['unit_id' => $unit_id, 'table' => 'obat'])->exists()){
            abort(403);
        }
        $requestData = $request->all();

        if ($requestData['jumlah'] <= 0) {
            return redirect('transaksi/obat')->with('error_message', 'Jumlah tidak boleh kosong!');
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

        Obat::updateOrCreate(
            [
                'periode' => $requestData['periode'],
                'unit_id' => $requestData['unit_id'],
                'uraian' => $requestData['uraian'],
            ],
            $requestData
        );
        Uraian::updateOrCreate(
            [
                'keterangan' => $requestData['uraian'],
                'satuan' => $requestData['satuan'],
                'bagian' => 'obat',
            ],
            [
                'harga' => $requestData['harga'],
            ]
        );
        Satuan::updateOrCreate(
            [
                'keterangan' => $requestData['satuan'],
            ],
            []
        );

        return redirect('transaksi/obat')
        ->with('flash_message', 'Obat added!')
        ->with('scrollto', 'ur-' . str_replace(' ','-',strtolower($requestData['uraian'])));
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
        if(!DB::table('unit_access')->where(['unit_id' => $unit_id, 'table' => 'obat'])->exists()){
            abort(403);
        }
        Obat::destroy($id);

        return redirect('transaksi/obat')->with('flash_message', 'Obat deleted!');
    }

    /**
     * For Print Out
     *
     */
    public function toexcel(Request $request)
    {
        $requestData = $request->all();
        $periode = date('Y-m-t', strtotime($requestData['periode'] ?? date('Y-m-t')));

        $obat = DB::select("call sp_to_excel('". $periode ."', 'obat')");

        array_unshift($obat, array_keys((array)$obat[0]));
        $data = new ArrayExport($obat);

        ob_end_clean(); // this
        ob_start(); // and this

        return Excel::download($data, date('Y-m').'_obat.xlsx');

    }

    public function periodesebelum(Request $request)
    {
        $requestData = $request->all();
        $periode = date('Y-m-t', strtotime($requestData['periode'] ?? date('Y-m-t')));
        $periodesebelum = date('Y-m-t', strtotime($requestData['periode'] ?? date('Y-m-t') . "-35 days"));

        "INSERT INTO obat (user_id,periode,uraian,satuan,unit_id,jumlah,harga,total)
        SELECT user_id,'2022-06-30',uraian,satuan,unit_id,jumlah,harga,total FROM obat a WHERE a.unit_id = 17 AND a.periode = '2021-12-31';";

        $unit_id = Auth::user()->unit;

        $dataperiodesebelum = Obat::select("user_id","uraian","satuan","unit_id","jumlah","harga","total")->selectRaw("'$periode' as periode")->where('periode', $periodesebelum)->where('unit_id', $unit_id)->get()->toArray();
        Obat::where('periode', $periode)->where('unit_id', $unit_id)->delete();
        Obat::insert($dataperiodesebelum);

        return redirect('transaksi/obat')->with('flash_message', 'Obat telah di isi dengan periode sebelumnya!');
    }

    public function import(Request $request)
    {
        Excel::import(new ObatImport, $request->file('excel'));

        return redirect('transaksi/obat')->with('flash_message', 'Obat imported!');
    }

    public function ambil_periode_sebelumnya(Request $request)
    {
        /*
        INSERT INTO obat (user_id,periode,uraian,satuan,unit_id,jumlah,harga,total) 
        SELECT user_id,'2022-02-28',uraian,satuan,unit_id,jumlah,harga,total FROM obat a WHERE a.unit_id = 17 AND a.periode = '2022-01-31';
        */
        return 0;
    }

}
