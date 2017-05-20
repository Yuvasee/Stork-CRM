<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ContactPerson;
use Illuminate\Http\Request;
use Session;

class ContactPersonsController extends Controller
{
    public function store($clientID, Request $request)
    {
        $this->validate($request, [
			'contact_name_new' => 'required'
		]);

        $requestData = [
            'name' => $request->contact_name_new,
            'client_id' => $clientID,
            'phone_work' => $request->phone_work_new,
            'phone_mobile' => $request->phone_mobile_new,
            'email' => $request->contact_email_new,
            'notes' => $request->notes_new,
        ];

        ContactPerson::create($requestData);

        return redirect('clients/' . $clientID . '/edit');
    }

    public function update($id, Request $request)
    {
        if (auth()->user()->cant('update', $request->client_id)) {
            return redirect('/clients/' . $request->client_id . '/edit');
        }

        $this->validate($request, [
            'contact_name' . $id => 'required'
        ]);

        $requestData = [
            'name' => $request->{'contact_name' . $id},
            'client_id' => $request->{'client_id' . $id},
            'phone_work' => $request->{'phone_work' . $id},
            'phone_mobile' => $request->{'phone_mobile' . $id},
            'email' => $request->{'contact_email' . $id},
            'notes' => $request->{'notes' . $id},
        ];
        
        $contactPerson = ContactPerson::findOrFail($id);
        $contactPerson->update($requestData);

        return redirect('clients/' . $requestData['client_id'] . '/edit');
    }

    public function destroy($id, Request $request)
    {
        if (auth()->user()->cant('update', $request->client_id)) {
            return redirect('/clients/' . $request->client_id . '/edit');
        }

        ContactPerson::destroy($id);

        return redirect('clients/' . $request->client_id . '/edit');
    }

}
