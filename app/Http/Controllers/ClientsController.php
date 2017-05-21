<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Client;
use Illuminate\Http\Request;
use Session;
use Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Cookie\CookieJar;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(CookieJar $cookieJar, Request $request)
    {
        // Make clients table filter
        $filter = $this->filterMake($cookieJar, $request);

        // Apply filter
        $clients = new Client;
        $clients = $this->filterApply($clients, $filter);

        // Apply search
        $keyword = $request->get('search');
        if (!empty($keyword)) {
            $clients = $clients
                ->where(function ($query) use ($keyword)
                {
                    $query
                        ->where('name', 'like', "%$keyword%")
                        ->orWhere('address', 'LIKE', "%$keyword%")
                        ->orWhere('post_address', 'LIKE', "%$keyword%")
                        ->orWhere('additional_info', 'LIKE', "%$keyword%")
                        ->orWhere('website', 'LIKE', "%$keyword%")
                        ->orWhere('tags', 'LIKE', "%$keyword%");
                });
        }

        // Add sorting
        $clients = $clients->orderBy('id', 'desc');

        if($request->has('showAll'))
        {
            $clients = $clients->limit(600)->get();
        }
        else
        {
            // Paginate rows
            $perPage = 50;
            $clients = $clients->paginate($perPage);
        }

        return view('clients.index', compact('clients', 'filter'));
    }

    /**
    * Make ready-to-apply filter from request (1st priority),
    * saved cookie (2nd) of default values (3rd)
    */
    private function filterMake($cookieJar, $request)
    {
        // Begin with empty array
        $filter = [];

        // Try to load values from cookie
        if (Cookie::has('filterClients'))
            $filter = unserialize(Cookie::get('filterClients'));

        // Manager
        // try request, overwrite cookie if exists
        if ($request->has('filterManager'))
        {
            $filter['manager'] = $request->filterManager;
        }
        // If still no value from request or cookie set default
        if (!array_key_exists('manager', $filter))
        {
            // Current user
            $filter['manager'] = auth()->user()->id;
        }

        // Client type
        // try request, overwrite cookie if exists
        if ($request->has('filterType'))
        {
            $filter['type'] = $request->filterType;
        }
        // If still no value from request or cookie set default
        if (!array_key_exists('type', $filter))
        {
            // 0 - select all types
            $filter['type'] = 0;
        }

        // City
        // try request, overwrite cookie if exists
        if ($request->has('filterCity'))
        {
            $filter['city'] = $request->filterCity;
        }
        // no data from request but filter is applyed - flush cookie values
        elseif ($request->has('isFiltered'))
        {
            $filter['city'] = "";
        }
        // If still no value from request or cookie set default
        if (!array_key_exists('city', $filter))
        {
            // Empty string - no filter applyed
            $filter['city'] = "";          
        }

        // Status
        // try request, overwrite cookie if exists
        if ($request->has('filterStatus'))
        {
            $filter['status'] = $request->filterStatus;
        }
        // If still no value from request or cookie set default
        if (!array_key_exists('status', $filter))
        {
            // 0 - select all statuses
            $filter['status'] = 0;
        }

        // Product groups
        // try request, overwrite cookie if exists
        if($request->has('filterProductGroups'))
        {
            $filter['productGroups'] = $request->filterProductGroups;
        }
        // no data from request but filter is applyed - flush cookie values
        elseif ($request->has('isFiltered'))
        {
            $filter['productGroups'] = [];
        }
        // If still no value from request or cookie set default
        if (!array_key_exists('productGroups', $filter))
        {
            // Empty
            $filter['productGroups'] = [];
        }        

        // Save made filter to cookie
        $cookieJar->queue(cookie('filterClients', serialize($filter), 45000));

        return $filter;
    }

    // Add filter to DB query
    private function filterApply($clients, $filter)
    {
        // Manager filter
        if ($filter['manager'] != 0)
            $clients = $clients
                ->where('manager_user_id', $filter['manager']);

        // Client type filter
        if ($filter['type'] != 0)
            $clients = $clients
                ->where('client_type_id', $filter['type']);

        // City filter by mask
        if ($filter['city'] != "")
            $clients = $clients
                ->where('city', 'like', '%' . $filter['city'] . '%');

        // Status filter
        if ($filter['status'] != 0)
            $clients = $clients
                ->where('client_status_id', '=', $filter['status']);

        // Product groups filter
        if (is_array($filter['productGroups']) && !empty($filter['productGroups']))
        {
            $filterProductGroups = $filter['productGroups'];

            // Create group (where || where)
            $clients = $clients
                ->where(function ($query) use ($filterProductGroups)
                {
                    // Add whereHas for each value
                    foreach ($filterProductGroups as $v)
                        $query->orWhereHas('productGroups', function ($query2) use ($v)
                        {
                            $query2->where('id', $v);
                        });
                });

        }

        return $clients;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $attachedPGs = [];
        return view('clients.create', compact('attachedPGs'));
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
            'client_type_id' => 'required|not_in:0',
            'client_status_id' => 'required|not_in:0',
            'client_source_id' => 'required|not_in:0',
		]);
        $requestData = $request->all();
        $requestData['created_by_user_id'] = Auth::user()->id;

        Client::create($requestData);

        Session::flash('flash_message', 'Client added!');

        return redirect('clients');
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
        $client = Client::findOrFail($id);

        $attachedPGs = $client->productGroups->pluck('id')->toArray();

        $contactPersons = $client->contactPersons->toArray();

        // Change form field names of contacts for form autopopulate
        foreach ($contactPersons as $key => $value) {
            $value['contact_name' . $value['id']] = $value['name'];
            $value['phone_work' . $value['id']] = $value['phone_work'];
            $value['phone_mobile' . $value['id']] = $value['phone_mobile'];
            $value['contact_email' . $value['id']] = $value['email'];
            $value['notes' . $value['id']] = $value['notes'];
            $contactPersons[$key] = $value;
        }

        $actionsPast = $client->actionsPast;
        $actionsFuture = $client->actionsFuture;

        return view('clients.show', compact('client', 'attachedPGs', 'contactPersons', 'actionsPast', 'actionsFuture'));
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
        $client = Client::findOrFail($id);

        if (auth()->user()->cant('update', $client)) {
            return redirect('/clients/' . $id);
        }

        $attachedPGs = $client->productGroups->pluck('id')->toArray();

        $contactPersons = $client->contactPersons->toArray();

        // Change form field names of contacts for form autopopulate
        foreach ($contactPersons as $key => $value) {
            $value['contact_name' . $value['id']] = $value['name'];
            $value['phone_work' . $value['id']] = $value['phone_work'];
            $value['phone_mobile' . $value['id']] = $value['phone_mobile'];
            $value['contact_email' . $value['id']] = $value['email'];
            $value['notes' . $value['id']] = $value['notes'];
            $contactPersons[$key] = $value;
        }

        $actionsPast = $client->actionsPast;
        $actionsFuture = $client->actionsFuture;

        return view('clients.edit', compact('client', 'attachedPGs', 'contactPersons', 'actionsPast', 'actionsFuture'));
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
            'client_type_id' => 'required|not_in:0',
            'client_status_id' => 'required|not_in:0',
            'client_source_id' => 'required|not_in:0',
		]);
        $requestData = $request->all();
        
        $client = Client::findOrFail($id);

        if (auth()->user()->cant('update', $client)) {
            return redirect('/clients');
        }

        $client->update($requestData);

        // Product groups m2m connections update
        $client->productGroups()->detach();
        if($request->product_groups){
            foreach ($request->product_groups as $pgID) {
               $client->productGroups()->attach($pgID);
            }
        }

        Session::flash('flash_message', 'Client updated!');

        return redirect('clients');
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
        $client = Action::findOrFail($id);

        if (auth()->user()->cant('update', $client)) {
            return redirect('/clients');
        }

        $client->delete();

        Session::flash('flash_message', 'Client deleted!');

        return redirect('clients');
    }
}
