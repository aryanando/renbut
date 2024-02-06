<?php

namespace App\Http\Controllers;

use App\Exports\SheetExport;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return DB::select('SELECT DATABASE() FROM DUAL;');
        // return DB::table('users')->get();
        return view('home');
    }

        /**
     * For Print Out
     *
     */
    public function toexcel(Request $request)
    {
        $requestData = $request->all();
        $periode = date('Y-m-t', strtotime($requestData['periode'] ?? date('Y-m-t')));
        
        $data = new SheetExport($periode);
        
        ob_end_clean(); // this
        ob_start(); // and this

        return Excel::download($data, 'Renbut ' . strtotime($requestData['periode'] ?? date('Y-m-t')) . '.xlsx');

    }

}
