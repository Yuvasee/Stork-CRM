<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Session;

class UsersController extends Controller
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
            $users = User::where('name', 'LIKE', "%$keyword%")
                ->orWhere('about', 'LIKE', "%$keyword%")
                ->get();
        } else {
            $users = User::get();
        }

        foreach ($users as $key => $value) {
            if($value->birthday) $value->birthday = \Carbon\Carbon::parse($value->birthday)->format('d.m.Y');
            if($value->hired_date) $value->hired_date = \Carbon\Carbon::parse($value->hired_date)->format('d.m.Y');
            if($value->fired_date) $value->fired_date = \Carbon\Carbon::parse($value->fired_date)->format('d.m.Y');
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = UserRole::pluck('name', 'id');

        return view('users.create', compact('roles'));
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
            'email' => 'required|email',
            'pw' => 'required|min:6',
        ]);
        $requestData = $request->all();
        $requestData['password'] = Hash::make($requestData['pw']);
        if($requestData['birthday']) {
            $requestData['birthday'] = \Carbon\Carbon::createFromFormat('d.m.Y', $requestData['birthday'])->toDateString();
        }
        if($requestData['hired_date']) {
            $requestData['hired_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $requestData['hired_date'])->toDateString();
        }

        User::create($requestData);

        Session::flash('flash_message', 'User added!');

        return redirect('users');
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
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
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
        $user = User::findOrFail($id);
        $roles = UserRole::pluck('name', 'id');

        if($user->birthday) $user->birthday = \Carbon\Carbon::parse($user->birthday)->format('d.m.Y');;
        if($user->hired_date) $user->hired_date = \Carbon\Carbon::parse($user->hired_date)->format('d.m.Y');;
        if($user->fired_date) $user->fired_date = \Carbon\Carbon::parse($user->fired_date)->format('d.m.Y');;

        return view('users.edit', compact('user', 'roles'));
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
        $val = [
            'name' => 'required',
            'email' => 'required|email',
        ];
        
        $requestData = $request->all();
        if($requestData['pw']){
            $val['pw'] = 'min:6';
            $requestData['password'] = Hash::make($requestData['pw']);
        }

        $this->validate($request, $val);

        if($requestData['birthday']) {
            $requestData['birthday'] = \Carbon\Carbon::createFromFormat('d.m.Y', $requestData['birthday'])->toDateString();
        }
        if($requestData['hired_date']) {
            $requestData['hired_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $requestData['hired_date'])->toDateString();
        }
        if($requestData['fired_date']) {
            $requestData['fired_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $requestData['fired_date'])->toDateString();
        }
        
        $user = User::findOrFail($id);
        $user->update($requestData);

        Session::flash('flash_message', 'User updated!');

        return redirect('users');
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
        User::destroy($id);

        Session::flash('flash_message', 'User deleted!');

        return redirect('users');
    }

    public function messages()
    {
        return [
            'email.email' => 'Нельзя без мыла, ёпт!',
        ];
    }
}
