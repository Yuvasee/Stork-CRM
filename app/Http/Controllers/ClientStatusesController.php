<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ClientStatus;
use Illuminate\Http\Request;
use Session;

class ClientStatusesController extends Controller
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
            $clientstatuses = ClientStatus::where('name', 'LIKE', "%$keyword%")
				->orWhere('color', 'LIKE', "%$keyword%")
				->orWhere('description', 'LIKE', "%$keyword%")
                ->get();
        } else {
            $clientstatuses = ClientStatus::get();
        }

        return view('client-statuses.index', compact('clientstatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('client-statuses.create');
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
        
        ClientStatus::create($requestData);

        Session::flash('flash_message', 'ClientStatus added!');

        return redirect('client-statuses');
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
        $clientstatus = ClientStatus::findOrFail($id);

        return view('client-statuses.edit', compact('clientstatus'));
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
        
        $clientstatus = ClientStatus::findOrFail($id);
        $clientstatus->update($requestData);

        Session::flash('flash_message', 'ClientStatus updated!');

        return redirect('client-statuses');
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
        ClientStatus::destroy($id);

        Session::flash('flash_message', 'ClientStatus deleted!');

        return redirect('client-statuses');
    }
}
