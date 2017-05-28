<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Import\Importer;

class ImportController extends Controller
{
    public function index(Request $request)
    {
        $message = null;

        if ($request->has('action')) {
            switch ($request->action) {
                case 'action-types':
                    $message = ['num' => Importer::actionTypes(), 'type' => 'ClientSource'];
                    break;
                case 'client-sources':
                    $message = ['num' => Importer::clientSources(), 'type' => 'ActionType'];
                    break;
                case 'client-types':
                    $message = ['num' => Importer::clientTypes(), 'type' => 'ClientType'];
                    break;
                case 'client-statuses':
                    $message = ['num' => Importer::clientStatuses(), 'type' => 'ClientStatus'];
                    break;
                case 'product-groups':
                    $message = ['num' => Importer::productGroups(), 'type' => 'ProductGroup'];
                    break;
                case 'users':
                    $message = ['num' => Importer::users(), 'type' => 'User'];
                    break;
                case 'clients':
                    $message = ['num' => Importer::clients(), 'type' => 'Client'];
                    break;
                case 'client-product-group':
                    $message = ['num' => Importer::clientProductGroup(), 'type' => 'ClientProductGroup'];
                    break;
                case 'contact-persons':
                    $message = ['num' => Importer::contactPersons(), 'type' => 'ContactPersons'];
                    break;
                case 'actions':
                    $message = ['num' => Importer::actions(), 'type' => 'Actions'];
                    break;
                case 'cities':
                    $message = ['num' => Importer::cities(), 'type' => 'Cities'];
                    break;
            }
        }

        return view('import/index', compact('message'));
    }

}