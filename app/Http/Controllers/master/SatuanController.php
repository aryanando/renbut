<?php

namespace App\Http\Controllers\master;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Auth;

class SatuanController extends Controller
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
        if(Auth::user()->unit != 999){
            abort(403);
        }

        if (!empty($keyword)) {
            $satuan = Satuan::where('keterangan', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $satuan = Satuan::latest()->paginate($perPage);
        }

        return view('master.satuan.index', compact('satuan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('master.satuan.create');
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
        
        $requestData["keterangan"] = ucfirst($requestData["keterangan"]);
        Satuan::create($requestData);

        return redirect('master/satuan')->with('flash_message', 'Satuan added!');
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
        $satuan = Satuan::findOrFail($id);

        return view('master.satuan.show', compact('satuan'));
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
        $satuan = Satuan::findOrFail($id);

        return view('master.satuan.edit', compact('satuan'));
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
        
        $satuan = Satuan::findOrFail($id);
        $requestData["keterangan"] = ucfirst($requestData["keterangan"]);
        $satuan->update($requestData);

        return redirect('master/satuan')->with('flash_message', 'Satuan updated!');
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
        Satuan::destroy($id);

        return redirect('master/satuan')->with('flash_message', 'Satuan deleted!');
    }
}
