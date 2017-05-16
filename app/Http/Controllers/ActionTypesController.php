<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ActionType;
use Illuminate\Http\Request;
use Session;

class ActionTypesController extends Controller
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
            $actiontypes = ActionType::where('name', 'LIKE', "%$keyword%")
				->orWhere('color', 'LIKE', "%$keyword%")
				->orWhere('description', 'LIKE', "%$keyword%")
                ->get();
        } else {
            $actiontypes = ActionType::get();
        }

        return view('action-types.index', compact('actiontypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('action-types.create');
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
        
        ActionType::create($requestData);

        Session::flash('flash_message', 'ActionType added!');

        return redirect('action-types');
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
        $actiontype = ActionType::findOrFail($id);

        return view('action-types.edit', compact('actiontype'));
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
        
        $actiontype = ActionType::findOrFail($id);
        $actiontype->update($requestData);

        Session::flash('flash_message', 'ActionType updated!');

        return redirect('action-types');
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
        ActionType::destroy($id);

        Session::flash('flash_message', 'ActionType deleted!');

        return redirect('action-types');
    }
}
