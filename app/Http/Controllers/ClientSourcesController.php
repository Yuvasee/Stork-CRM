<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ClientSource;
use Illuminate\Http\Request;
use Session;

class ClientSourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');

        if (!empty($keyword)) {
            $clientsources = ClientSource::where('name', 'LIKE', "%$keyword%")
				->orWhere('color', 'LIKE', "%$keyword%")
				->orWhere('description', 'LIKE', "%$keyword%")
                ->get();
        } else {
            $clientsources = ClientSource::get();
        }

        return view('client-sources.index', compact('clientsources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('client-sources.create');
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
        ClientSource::create($requestData);

        Session::flash('flash_message', 'ClientSource added!');

        return redirect('client-sources');
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
        $clientsource = ClientSource::findOrFail($id);

        return view('client-sources.edit', compact('clientsource'));
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
        
        $clientsource = ClientSource::findOrFail($id);
        $clientsource->update($requestData);

        Session::flash('flash_message', 'ClientSource updated!');

        return redirect('client-sources');
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
        ClientSource::destroy($id);

        Session::flash('flash_message', 'ClientSource deleted!');

        return redirect('client-sources');
    }
}
