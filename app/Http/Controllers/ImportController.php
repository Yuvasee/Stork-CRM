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
            }
        }

        return view('import/index', compact('message'));
    }

/**

    private function client_product_group()
    {
        // Сопоставляем клиентов (берем из таблицы)
        $matchData = DB::select('select * from client_old_new');
        $clientsMatch = [];
        foreach ($matchData as $matchRow) {
            $clientsMatch[$matchRow->old_client_id] = $matchRow->new_client_id;
        }

        // Сопоставляем товарные категории
        $oldPgs = DB::connection('import')->select('select * from products_types');
        $pgsMatch = [];
        foreach ($oldPgs as $oldPg) {
            $pgsMatch[$oldPg->product_type_id] = ProductGroup::where('name', $oldPg->name)->first()->id;
        }

        $oldData = DB::connection('import')->select('select * from clients_has_products_types');

        DB::table('client_product_group')->truncate();

        $i = 0;
        foreach ($oldData as $oldRow) {
            if(array_key_exists($oldRow->clients_client_id, $clientsMatch) &&
               array_key_exists($oldRow->products_types_product_type_id, $pgsMatch)){
                DB::table('client_product_group')->insert([
                        'client_id' => $clientsMatch[$oldRow->clients_client_id],
                        'product_group_id' => $pgsMatch[$oldRow->products_types_product_type_id]
                    ]);                
                $i++;
            }
        }
     
        return ['num' => $i, 'type' => 'client_product_group'];

    }

    private function contact_persons()
    {
        // Сопоставляем клиентов (берем из таблицы)
        $matchData = DB::select('select * from client_old_new');
        $clientsMatch = [];
        foreach ($matchData as $matchRow) {
            $clientsMatch[$matchRow->old_client_id] = $matchRow->new_client_id;
        }
        
        $oldData = DB::connection('import')->select('select * from people');

        DB::table('contact_persons')->truncate();

        $i = 0;
        foreach ($oldData as $value) {
            if(array_key_exists($value->client_id, $clientsMatch)){
                $row = [
                    'name' => $value->FIO,
                    'client_id' => $clientsMatch[$value->client_id],
                    'phone_work' => $value->telefon,
                    'phone_mobile' => $value->telefon_mobile,
                    'email' => $value->email,
                    'notes' => $value->comment,
                ];

                ContactPerson::create($row);

                $i++;
            }

        }

        return ['num' => $i, 'type' => 'ContactPerson'];

    }
 
    private function actions()
    {
        $tBegin = \Carbon\Carbon::now();

        // Сопоставляем клиентов (берем из таблицы)
        $matchData = DB::select('select * from client_old_new');
        $clientsMatch = [];
        foreach ($matchData as $matchRow) {
            $clientsMatch[$matchRow->old_client_id] = $matchRow->new_client_id;
        }
        
        // Сопоставляем типы событий
        $oldTypes = DB::connection('import')
            ->select('select * from cmb_action_type');
        $typesMatch = [];
        foreach ($oldTypes as $oldType) {
            $typesMatch[$oldType->ID] = ActionType::where('name', $oldType->Value)->first()->id;
        }
        $typesMatch[-1] = ActionType::where('name', 'Тип не установлен')->first()->id;

        // Сопоставляем пользователей
        $oldUsers = DB::connection('import')
            ->select('select * from users');
        $usersMatch = [];
        foreach ($oldUsers as $oldUser) {
            $usersMatch[$oldUser->user_id] = User::where('name', $oldUser->name . ' ' . $oldUser->surname)->first()->id;
        }

        // Получаем данные из старой базы
        $oldData = DB::connection('import')->select('select * from action limit 10000 offset 101000');

        // Очищаем таблицу в новой базе
        // DB::table('actions')->truncate();

        // Переносим данные
        $i = 0;
        foreach ($oldData as $value) {
            if(array_key_exists($value->client_id, $clientsMatch)
                && array_key_exists($value->UID, $usersMatch)){
                $row = [
                    'client_id' => $clientsMatch[$value->client_id],
                    'status' => $value->isDel,
                    'action_date' => preg_replace('/-00$/', '-01', $value->dtAction),
                    'action_type_id' => isset($typesMatch[$value->cmb_action_type]) ? $typesMatch[$value->cmb_action_type] : $typesMatch[-1],
                    'manager_user_id' => $usersMatch[$value->UID],
                    'description' => $value->Description,
                    'tags' => $value->Sign,
                ];

                Action::create($row);

                $i++;
            }

        }

        return ['num' => $i, 'type' => 'Action', 'time' => \Carbon\Carbon::now()->diffInSeconds($tBegin)];

    }
*/
}