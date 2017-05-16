<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Import\Importer;
//use App\ClientSource;
/**
use App\ActionType;
use App\ClientType;
use App\ClientStatus;
use App\ProductGroup;
use App\User;
use App\Client;
use App\ContactPerson;
use App\Action;
*/

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
/**
                case 'client-statuses':
                    $message = $this->client_statuses();
                    break;
                case 'product-groups':
                    $message = $this->product_groups();
                    break;
                case 'users':
                    $message = $this->users();
                    break;
                case 'clients':
                    $message = $this->clients();
                    break;
                case 'client-product-group':
                    $message = $this->client_product_group();
                    break;
                case 'contact-persons':
                    $message = $this->contact_persons();
                    break;
                case 'actions':
                    $message = $this->actions();
                    break;
                    */
            }
        }

        return view('import/index', compact('message'));
    }

/**
    private function action_types()
    {
    	$oldData = DB::connection('import')
    		->select('select * from cmb_action_type`');

    	DB::table('action_types')->truncate();

    	foreach ($oldData as $key => $value) {

    		$row = [
    			'name' => $value->Value,
    			'sorting_num' => $value->SortID,
    		];

	        ActionType::create($row);

    	};

        ActionType::create(['name' => 'Тип не установлен', 'sorting_num' => 999999]);

        return [
            'num' => count($oldData),
            'type' => 'ActionType'
        ];
    }

    private function client_types()
    {
    	$oldData = DB::connection('import')
    		->select('select * from cmb_type`');

    	DB::table('client_types')->truncate();

    	$i = 1;
        foreach ($oldData as $key => $value) {
    		$row = [
    			'name' => $value->Value,
                'sorting_num' => $i * 10,
    		];

	        ClientType::create($row);
            $i++;
    	};

        ClientType::create(['name' => 'Тип не установлен', 'sorting_num' => 999999]);

        return ['num' => count($oldData), 'type' => 'ClientType'];
    }

    private function client_statuses()
    {
    	$oldData = DB::connection('import')
    		->select('select * from cmb_probability_contract`');

    	DB::table('client_statuses')->truncate();

        $i = 1;
       	foreach ($oldData as $key => $value) {

    		$row = [
    			'name' => $value->Value,
                'sorting_num' => $i * 10,
       		];

	        ClientStatus::create($row);
            $i++;
    	};

        ClientStatus::create(['name' => 'Статус не установлен', 'sorting_num' => 999999]);

        return ['num' => count($oldData), 'type' => 'ClientStatus'];
    }

    private function client_sources()
    {
    	$oldData = DB::connection('import')
    		->select('select * from cmb_clientfrom');

    	DB::statement('set foreign_key_checks = 0');
        DB::table('client_sources')->truncate();
        DB::statement('set foreign_key_checks = 1');

    	foreach ($oldData as $key => $value) {

    		$row = [
    			'name' => $value->Value,
    			'sorting_num' => $value->SortID,
    		];

	        ClientSource::create($row);

    	};

        ClientSource::create(['name' => 'Источник не установлен', 'sorting_num' => 999999]);

        return ['num' => count($oldData), 'type' => 'ClientSource'];
    }

    private function product_groups()
    {
    	$oldData = DB::connection('import')
    		->select('select * from products_types');

    	DB::table('product_groups')->truncate();

    	$i = 1;
        foreach ($oldData as $key => $value) {

    		$row = [
    			'name' => $value->name,
                'sorting_num' => $i * 10,
    		];

	        ProductGroup::create($row);
            $i++;
    	};

        return ['num' => count($oldData), 'type' => 'ProductGroup'];
    }

    private function users()
    {
        $oldData = DB::connection('import')
            ->select('select * from users');

        DB::table('users')->where('id', '<>', 1)->delete();

        // Ищем и меняем одинаковые email
        $emails = [];
        $i = 1;
        foreach ($oldData as $key => $value) {
            if(array_search($value->email_work, $emails)){
                array_push($emails, preg_replace('([_[:alnum:]]+)(@.+)', '${1}' . $i . '$2', $value->email_work));
                $i++;
            }
            else {
                array_push($emails, $value->email_work);
            }
        }

        foreach ($oldData as $key => $value) {

            $pass = str_random(6);

            $row = [
                'name' => $value->name . ' ' . $value->surname,
                'email' => $emails[$key],
                'password' => Hash::make($pass),
                'user_role_id' => 2,
                'phone_number' => $value->phone_mobile,
                'birthday' => $value->birthday,
                'hired_date' => $value->work_start_date,
                'fired_date' => $value->work_end_date,
                'about' => $pass,
            ];

            User::create($row);

        };

        return ['num' => count($oldData), 'type' => 'User'];
    }

    private function clients()
    {
        // Сопоставляем типы клиентов
        $oldTypes = DB::connection('import')
            ->select('select * from cmb_type');
        $typesMatch = [];
        foreach ($oldTypes as $oldType) {
            $typesMatch[$oldType->ID] = ClientType::where('name', $oldType->Value)->first()->id;
        }
        $typesMatch[-1] = ClientType::where('name', 'Тип не установлен')->first()->id;

        // Сопоставляем статусы
        $oldStatuses = DB::connection('import')
            ->select('select * from cmb_probability_contract');
        $statusesMatch = [];
        foreach ($oldStatuses as $oldStatus) {
            $statusesMatch[$oldStatus->ID] = ClientStatus::where('name', $oldStatus->Value)->first()->id;
        }
        $statusesMatch[-1] = ClientStatus::where('name', 'Статус не установлен')->first()->id;

        // Сопоставляем источники
        $oldSources = DB::connection('import')
            ->select('select * from cmb_clientfrom');
        $sourcesMatch = [];
        foreach ($oldSources as $oldSource) {
            $sourcesMatch[$oldSource->ID] = ClientSource::where('name', $oldSource->Value)->first()->id;
        }
        $sourcesMatch[-1] = ClientSource::where('name', 'Источник не установлен')->first()->id;

        // Сопоставляем пользователей
        $oldUsers = DB::connection('import')
            ->select('select * from users');
        $usersMatch = [];
        foreach ($oldUsers as $oldUser) {
            $usersMatch[$oldUser->user_id] = User::where('name', $oldUser->name . ' ' . $oldUser->surname)->first()->id;
        }

        // Переносим клиентов
        $oldClients = DB::connection('import')
            ->select('select * from clients');

        DB::table('clients')->truncate();

        $clientsMatch = [];
        foreach ($oldClients as $oldClient) {

            // В названии меняем &quot; на "
            $oldClient->name = mb_ereg_replace('&quot;', '"', $oldClient->name);

            // Сохраняем данные, которые не попадают в основные поля в доп информацию
            $additional_info = [];
            if($oldClient->production) array_push($additional_info, 'Продукция по состояниям: ' . $oldClient->production);
            if($oldClient->production_stad) array_push($additional_info, 'Продукция по стадиям: ' . $oldClient->production_stad);
            if(strlen($oldClient->name) > 191){
                array_push($additional_info, 'Название: ' . $oldClient->name);
                $oldClient->name = mb_substr($oldClient->name, 0, 191);
            }
            if(strlen($oldClient->phones) > 191){
                array_push($additional_info, 'Телефоны: ' . $oldClient->phones);
                $oldClient->phones = mb_substr($oldClient->phones, 0, 191);
            }
            if(strlen($oldClient->email) > 191){
                array_push($additional_info, 'Email: ' . $oldClient->email);
                $oldClient->email = mb_substr($oldClient->email, 0, 191);
            }
            if(strlen($oldClient->sity) > 191){
                array_push($additional_info, 'Город: ' . $oldClient->sity);
                $oldClient->sity = mb_substr($oldClient->sity, 0, 191);
            }
            if(strlen($oldClient->region_name) > 191){
                array_push($additional_info, 'Регион: ' . $oldClient->region_name);
                $oldClient->region_name = mb_substr($oldClient->region_name, 0, 191);
            }
            if(strlen($oldClient->region_code) > 191){
                array_push($additional_info, 'Код региона: ' . $oldClient->region_code);
                $oldClient->region_code = mb_substr($oldClient->region_code, 0, 191);
            }
            if(strlen($oldClient->signs) > 191){
                array_push($additional_info, 'Признак: ' . $oldClient->signs);
                $oldClient->signs = mb_substr($oldClient->signs, 0, 191);
            }
            if(strlen($oldClient->Sites) > 191){
                array_push($additional_info, 'Сайты: ' . $oldClient->Sites);
                $oldClient->Sites = mb_substr($oldClient->Sites, 0, 191);
            }

            $row = [
                'name' => $oldClient->name,
                'client_type_id' => isset($typesMatch[$oldClient->cmb_type]) ? $typesMatch[$oldClient->cmb_type] : $typesMatch[-1],
                'client_status_id' => isset($statusesMatch[$oldClient->cmb_probability_contract]) ? $statusesMatch[$oldClient->cmb_probability_contract] : $statusesMatch[-1],
                'client_source_id' => isset($sourcesMatch[$oldClient->cmb_clientfrom]) ? $sourcesMatch[$oldClient->cmb_clientfrom] : $sourcesMatch[-1],
                'manager_user_id' => ($oldClient->UID > 0) ? $usersMatch[$oldClient->UID] : 1,
                'phone_number' => $oldClient->phones,
                'email' => $oldClient->email,
                'address' => $oldClient->full_adress,
                'post_address' => $oldClient->post_adress,
                'city' => $oldClient->sity,
                'region' => $oldClient->region_name,
                'region_code' => $oldClient->region_code,
                'tags' => $oldClient->signs,
                'additional_info' => implode("\n", $additional_info),
                'website' => $oldClient->Sites,
                'created_by_user_id' => 1,
                'created_at' => $oldClient->addition_date,
            ];

            $clientsMatch[$oldClient->client_id] = Client::create($row)->id;

        };

        // Заполняем таблицу сопоставлений ID старых и новых клиентов
        DB::table('client_old_new')->delete();
        foreach ($clientsMatch as $key => $value) {
            DB::table('client_old_new')->insert(
                ['old_client_id' => $key, 'new_client_id' => $value]
            );
        }

        // Переносим связи клиентов и товарных категорий

        return ['num' => count($oldClients), 'type' => 'Client'];

    }


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