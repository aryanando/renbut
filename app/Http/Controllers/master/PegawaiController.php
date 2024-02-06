<?php

namespace App\Http\Controllers\master;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Pegawai;
use App\Models\Unit;
use Illuminate\Http\Request;
use Auth;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->unit != 999){
                abort(403);
            }        
    
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $pegawai = Pegawai::leftJoin('units','pegawai.unit_id','units.id')->select(['pegawai.id','pegawai.nama','pegawai.gender','pegawai.unit_id','units.keterangan'])->where('nama', 'LIKE', "%$keyword%")
                ->orWhere('gender', 'LIKE', "%$keyword%")
                ->orWhere('unit_id', 'LIKE', "%$keyword%")
                ->orWhere('cuti', 'LIKE', "%$keyword%")
                ->orderby('keterangan')->orderby('nama')->paginate($perPage);
        } else {
            $pegawai = Pegawai::leftJoin('units','pegawai.unit_id','units.id')->select(['pegawai.id','pegawai.nama','pegawai.gender','units.keterangan'])->orderby('keterangan')->orderby('nama')->paginate($perPage);
        }

        return view('master.pegawai.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $unit = Unit::orderby('keterangan')->get();
        return view('master.pegawai.create', compact('unit'));
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
        
        $requestData = $request->all();
        
        Pegawai::create($requestData);

        return redirect('master/pegawai')->with('flash_message', 'Pegawai added!');
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
        $pegawai = Pegawai::findOrFail($id);

        return view('master.pegawai.show', compact('pegawai'));
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
        $pegawai = Pegawai::findOrFail($id);
        $unit = Unit::orderby('keterangan')->get();

        return view('master.pegawai.edit', compact('pegawai','unit'));
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
        
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($requestData);

        return redirect('master/pegawai')->with('flash_message', 'Pegawai updated!');
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
        Pegawai::destroy($id);

        return redirect('master/pegawai')->with('flash_message', 'Pegawai deleted!');
    }
}
