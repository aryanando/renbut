<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Imports\SarprasImport;
use Illuminate\Http\Request;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class SarprasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('transaksi.gizi.index');
    }

    public function import(Request $request)
    {
        $file = $request->file('excel');

        if($file){
            
            return redirect('transaksi/sarpras')->with('flash_message', 'File terupload!');
        }

        return redirect('transaksi/sarpras')->with('error_message', 'Tidak ada data file!');
    }

}
