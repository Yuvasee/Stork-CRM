<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Action;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use Illuminate\Support\Facades\Cookie;
use Session;
use Carbon\Carbon;
use App\Helpers\Helpers;

class ActionsController extends Controller
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
        $actions = new Action;
        $actions = $this->filterApply($actions, $filter);

        // Apply search
        $keyword = $request->get('search');
        if (!empty($keyword)) {
            $actions = $actions
                ->where(function ($query) use ($keyword)
                {
                    $query
                        ->whereHas('client', function ($query2) use ($keyword)
                        {
                            $query2->where('name', 'like', "%$keyword%");
                        })
                        ->orWhere('description', 'LIKE', "%$keyword%")
                        ->orWhere('tags', 'LIKE', "%$keyword%");
                });
        }


        // Add sorting
        $actions = $actions
            ->orderBy('status')
            ->orderBy('action_date', 'desc');

        // Paginate rows
        $perPage = 50;
        $actions = $actions->paginate($perPage);

        return view('actions.index', compact('actions', 'filter'));
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
        if (Cookie::has('filterActions'))
            $filter = unserialize(Cookie::get('filterActions'));

        // Dates
        // try request, overwrite cookie if exists
        if ($request->has('filterDates'))
        {
            $filterDatesArray = preg_split('/ - /', $request->filterDates);
            $filter['datesFrom'] = Carbon::parse($filterDatesArray[0]);
            $filter['datesTo'] = Carbon::parse($filterDatesArray[1]);
        }
        // If still no value from request or cookie set default
        if (!array_key_exists('datesFrom', $filter))
        {
            $filter['datesFrom'] = Carbon::parse("first day of this month");
            $filter['datesTo'] = Carbon::parse("last day of this month");
        }

        // Manager
        // try request, overwrite cookie if exists
        if ($request->has('filterManager'))
        {
            $filter['manager'] = $request->filterManager;
        }
        // If still no value from request or cookie set default
        if (!array_key_exists('manager', $filter))
        {
            // current user
            $filter['manager'] = auth()->user()->id;
        }

        // Client search by mask
        // try request, overwrite cookie if exists
        if ($request->has('filterClient'))
        {
            $filter['client'] = $request->filterClient;
        }
        // no data from request but filter is applyed - flush cookie values
        elseif ($request->has('filterDates'))
        {
            $filter['client'] = "";
        }
        // If still no value from request or cookie set default
        if (!array_key_exists('client', $filter))
        {
            $filter['client'] = "";
        }

        // City search by mask
        // try request, overwrite cookie if exists
        if ($request->has('filterCity'))
        {
            $filter['city'] = $request->filterCity;
        }
        // no data from request but filter is applyed - flush cookie values
        elseif ($request->has('filterDates'))
        {
            $filter['city'] = "";
        }
        // If still no value from request or cookie set default
        if (!array_key_exists('city', $filter))
        {
            $filter['city'] = "";
        }

        // Statuses
        // try request, overwrite cookie if exists
        if ($request->has('filterStatuses'))
        {
            $filter['statuses'] = $request->filterStatuses;
        }
        // no data from request but filter is applyed - default values
        elseif ($request->has('filterDates'))
        {
            $filter['statuses'] = [0, 1];
        }
        // If still no value from request or cookie set default
        if (!array_key_exists('statuses', $filter))
        {
            $filter['statuses'] = [0, 1];
        }

        // Save filter in cookie
        $cookieJar->queue(cookie('filterActions', serialize($filter), 45000));

        return $filter;
    }

    // Add filter to DB query
    private function filterApply($actions, $filter)
    {
        // Dates (filter ever)
        $actions = $actions
            ->where('action_date', '>=', $filter['datesFrom'])
            ->where('action_date', '<=', $filter['datesTo']);

        // Mananges
        if ($filter['manager'] != 0)
            $actions = $actions
                ->where('manager_user_id', $filter['manager']);

        // Clients
        if ($filter['client'] != "")
        {
            $filterClient = $filter['client'];
            $actions = $actions
                ->whereHas('client', function ($query) use ($filterClient) {
                    $query->where('name', 'like', "%$filterClient%");
                });
        }

        // City
        if ($filter['city'] != "")
        {
            $filterCity = $filter['city'];
            $actions = $actions
                ->whereHas('client', function ($query) use ($filterCity) {
                    $query->where('city', 'like', "%$filterCity%");
                });
        }

        // Statuses
        if (count($filter['statuses']) == 1)
            $actions = $actions
                ->where('status', $filter['statuses'][0]);

        return $actions;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $client_id = $request->input('client_id');
        $client = Client::findOrFail($client_id);

        $back_to_url = Helpers::getBackUrl('/actions');
        
        return view('actions.create', compact('client', 'back_to_url'));
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
			'action_date' => 'required',
            'action_type_id' => 'required|not_in:0'
		]);
        $requestData = $request->all();
        
        if($requestData['action_date']) {
            $requestData['action_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $requestData['action_date'])->toDateString();
        }

        Action::create($requestData);

        Session::flash('flash_message', 'Событие создано.');

        if(session('back_to_url'))
            return redirect(session('back_to_url'));

        return redirect('actions');
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
        $action = Action::findOrFail($id);

        return view('actions.show', compact('action'));
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
        
        $action = Action::findOrFail($id);

        if (auth()->user()->cant('update', $action)) {
            return redirect('/');
        }

        $client = $action->client;

        $back_to_url = Helpers::getBackUrl('/actions');

        return view('actions.edit', compact('action', 'client', 'back_to_url'));
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
			'action_date' => 'required'
		]);
        $requestData = $request->all();
        
        if(isset($requestData['action_date'])) {
            $requestData['action_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $requestData['action_date'])->toDateString();
        }

        $action = Action::findOrFail($id);

        if (auth()->user()->cant('update', $action)) {
            return redirect('/');
        }

        $action->update($requestData);

        if(isset($requestData['client_status_id'])) {
            $action->client->client_status_id = $requestData['client_status_id'];
            $action->client->save();
        }

        Session::flash('flash_message', 'Событие обновлено.');

        // Если установлена галка "создать новое событие" - редиректим на новое событие
        if(isset($requestData['add_new_action']))
        {
            if(session('back_to_url'))
            {
                // Если уже есть обратный путь, то перезаписываем его опять
                Session::flash('back_to_url', session('back_to_url'));
                
            }

            return redirect('actions/create?client_id=' . $action->client->id);
        }

        if(session('back_to_url'))
            return redirect(session('back_to_url'));

        return redirect('actions');
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
        $action = Action::findOrFail($id);

        if (auth()->user()->cant('update', $action)) {
            return redirect('/');
        }

        $action->delete();

        Session::flash('flash_message', 'Action deleted!');

        $back_to_url = Helpers::getBackUrl('/actions');

        return redirect($back_to_url);
    }
}
