<?php

namespace App\Http\Controllers\gudang;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Uraian;
use App\Models\Satuan;
use App\Models\cetak;
use Auth;
use App\Exports\ArrayExport;
use App\Imports\cetakImport;
use App\Models\Unit;
use Maatwebsite\Excel\Facades\Excel;
class GudangCetakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // $cetak = DB::select("call sp_cetak('". htmlspecialchars(date('Y-m-t', strtotime($date)))."', ?)", [$unit]);
        $cetak= Uraian::where('bagian','=','cetak')->orderby('keterangan')->get();
        $uraian = Uraian::where('bagian', 'cetak')->orderby('keterangan')->get();
        $satuan = Satuan::orderby('keterangan')->get();
        $unit = Unit::leftJoin('unit_access', 'unit_access.unit_id', 'units.id')->where('table', 'cetak')->where('unit_id', '<>', 999)->orderby('keterangan')->get();

        return view('transaksi.gudang.cetak.index', compact('cetak', 'uraian', 'satuan', 'unit'));
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
        if(!DB::table('unit_access')->where(['unit_id' => $unit_id, 'table' => 'cetak'])->exists()){
            abort(403);
        }
        $requestData = $request->all();

        if ($requestData['stok'] < 0) {
            return redirect('transaksi/gudang/cetak')->with('error_message', 'Stok tidak boleh minus!');
        }
        if (empty(str_replace(' ', '', $requestData['uraian']))) {
            return redirect('transaksi/gudang/cetak')->with('error_message', 'Uraian tidak boleh kosong!');
        }

        $unit_id = Auth::user()->unit;
        $requestData['user_id'] = Auth::user()->id;
        $requestData['uraian'] = strtoupper($requestData['uraian']);
        $requestData['satuan'] = ucfirst(strtolower($requestData['satuan']));

        Uraian::updateOrCreate(
            [
                'keterangan' => $requestData['uraian'],
                'satuan' => $requestData['satuan'],
                'bagian' => 'cetak',
            ],
            [
                'harga' => $requestData['harga'],
                'stok' => $requestData['stok'],
            ]
        );
        Satuan::updateOrCreate(
            [
                'keterangan' => $requestData['satuan'],
            ],
            []
        );

        return redirect('gudang/cetak')->with('flash_message', 'cetak added!');
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
        if(!DB::table('unit_access')->where(['unit_id' => $unit_id, 'table' => 'cetak'])->exists()){
            abort(403);
        }
        cetak::destroy($id);

        // return response()->json(['message' => 'Terhapus']);
        return redirect('transaksi/gudang/cetak');
    }

    public function edit($id)
    {
        $uraian = Uraian::find($id);
        $satuan = Satuan::orderby('keterangan')->get();
        // if($uraian){
        //     return response()->json([
        //         'status'=>200,
        //         'uraian'=> $uraian,
        //     ]);
        // }
        // else{
        //     return response()->json([
        //         'status'=>404,
        //         'message'=> 'Data tidak ada',
        //     ]);
        // }
        return view('transaksi.gudang.cetak.edit', compact('uraian','satuan'));
    }

    public function update(Request $request,$id){
        $requestData = $request->all();
        
        $uraian = Uraian::findOrFail($id);
        $requestData["keterangan"] = strtoupper($requestData["keterangan"]);
        $requestData["satuan"] = $requestData["satuan"];
        $requestData["stok"] = $requestData["stok"];
        $requestData["harga"] = $requestData["harga"];
        $uraian->update($requestData);

        return redirect('gudang/cetak')->with('flash_message', 'Uraian updated!');
    }
    /**
     * For Print Out
     *
     */
    public function toexcel(Request $request)
    {
        $requestData = $request->all();

        $cetak = DB::select("call sp_gudang('cetak')");

        array_unshift($cetak, array_keys((array)$cetak[0]));
        $data = new ArrayExport($cetak);

        ob_end_clean(); // this
        ob_start(); // and this

        return Excel::download($data, date('Y-m').'_cetak.xlsx');

    }

    public function import(Request $request)
    {
        Excel::import(new cetakImport, $request->file('excel'));

        return redirect('transaksi/cetak')->with('flash_message', 'cetak imported!');
    }

}
