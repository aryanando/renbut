<?php

namespace App\Http\Controllers\master;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Unit;
use Illuminate\Http\Request;
use Auth;

class UnitController extends Controller
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
            $unit = Unit::where('keterangan', 'LIKE', "%$keyword%")
                ->orderby('keterangan')->paginate($perPage);
        } else {
            $unit = Unit::orderby('keterangan')->paginate($perPage);
        }

        return view('master.unit.index', compact('unit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('master.unit.create');
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
        
        $requestData["keterangan"] = strtolower($requestData["keterangan"]);
        Unit::create($requestData);

        return redirect('master/unit')->with('flash_message', 'Unit added!');
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
        $unit = Unit::findOrFail($id);

        return view('master.unit.show', compact('unit'));
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
        $unit = Unit::findOrFail($id);

        return view('master.unit.edit', compact('unit'));
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
        
        $unit = Unit::findOrFail($id);
        $requestData["keterangan"] = strtolower($requestData["keterangan"]);
        $unit->update($requestData);

        return redirect('master/unit')->with('flash_message', 'Unit updated!');
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
        Unit::destroy($id);

        return redirect('master/unit')->with('flash_message', 'Unit deleted!');
    }
}
