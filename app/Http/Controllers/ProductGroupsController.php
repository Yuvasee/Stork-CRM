<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProductGroup;
use Illuminate\Http\Request;
use Session;

class ProductGroupsController extends Controller
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
            $productgroups = ProductGroup::where('name', 'LIKE', "%$keyword%")
				->orWhere('color', 'LIKE', "%$keyword%")
				->orWhere('description', 'LIKE', "%$keyword%")
                ->get();
        } else {
            $productgroups = ProductGroup::get();
        }

        return view('product-groups.index', compact('productgroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('product-groups.create');
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
        
        ProductGroup::create($requestData);

        Session::flash('flash_message', 'ProductGroup added!');

        return redirect('product-groups');
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
        $productgroup = ProductGroup::findOrFail($id);

        return view('product-groups.edit', compact('productgroup'));
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
        
        $productgroup = ProductGroup::findOrFail($id);
        $productgroup->update($requestData);

        Session::flash('flash_message', 'ProductGroup updated!');

        return redirect('product-groups');
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
        ProductGroup::destroy($id);

        Session::flash('flash_message', 'ProductGroup deleted!');

        return redirect('product-groups');
    }
}
