<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ClientType;
use Illuminate\Http\Request;
use Session;

class ClientTypesController extends Controller
{
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
            $clienttypes = ClientType::where('name', 'LIKE', "%$keyword%")
				->orWhere('color', 'LIKE', "%$keyword%")
				->orWhere('description', 'LIKE', "%$keyword%")
                ->get();
        } else {
            $clienttypes = ClientType::get();
        }

        return view('client-types.index', compact('clienttypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('client-types.create');
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
        $this->validate($request, [
			'name' => 'required',
            'sorting_num' => 'integer',
		]);
        $requestData = $request->all();
        
        ClientType::create($requestData);

        Session::flash('flash_message', 'ClientType added!');

        return redirect('client-types');
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
        $clienttype = ClientType::findOrFail($id);

        return view('client-types.edit', compact('clienttype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
			'name' => 'required',
            'sorting_num' => 'integer',
		]);
        $requestData = $request->all();
        
        $clienttype = ClientType::findOrFail($id);
        $clienttype->update($requestData);

        Session::flash('flash_message', 'ClientType updated!');

        return redirect('client-types');
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
        ClientType::destroy($id);

        Session::flash('flash_message', 'ClientType deleted!');

        return redirect('client-types');
    }
}
