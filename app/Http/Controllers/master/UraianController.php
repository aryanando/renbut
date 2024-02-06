<?php

namespace App\Http\Controllers\master;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Uraian;
use Illuminate\Http\Request;
use Auth;

class UraianController extends Controller
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
            $uraian = Uraian::where('keterangan', 'LIKE', "%$keyword%")
                ->orWhere('satuan', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $uraian = Uraian::latest()->paginate($perPage);
        }

        return view('master.uraian.index', compact('uraian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('master.uraian.create');
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
        
        $requestData["keterangan"] = strtoupper($requestData["keterangan"]);

        Uraian::create($requestData);

        return redirect('master/uraian')->with('flash_message', 'Uraian added!');
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
        $uraian = Uraian::findOrFail($id);

        return view('master.uraian.show', compact('uraian'));
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
        $uraian = Uraian::findOrFail($id);

        return view('master.uraian.edit', compact('uraian'));
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
        
        $uraian = Uraian::findOrFail($id);
        $requestData["keterangan"] = strtoupper($requestData["keterangan"]);
        $uraian->update($requestData);

        return redirect('master/uraian')->with('flash_message', 'Uraian updated!');
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
        Uraian::destroy($id);

        return redirect('master/uraian')->with('flash_message', 'Uraian deleted!');
    }
}
