<?php

namespace App\Import;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\ClientSource;
use App\ActionType;
use App\ClientType;
use App\ClientStatus;
use App\ProductGroup;
use App\User;
use App\Client;
use App\ContactPerson;
use App\Action;

class Importer
{
    public static function actionTypes()
    {
    	$oldData = DB::connection('import')
    		->select('select * from cmb_action_type`');

    	self::truncTable('action_types');

    	foreach ($oldData as $key => $value) {

    		$row = [
    			'name' => $value->Value,
    			'sorting_num' => $value->SortID,
    		];

	        ActionType::create($row);

    	};

        ActionType::create(['name' => 'Тип не установлен', 'sorting_num' => 999999]);

        return count($oldData);
    }

    public static function clientTypes()
    {
    	$oldData = DB::connection('import')
    		->select('select * from cmb_type`');

    	self::truncTable('client_types');

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

        return count($oldData);
    }

    public static function clientStatuses()
    {
    	$oldData = DB::connection('import')
    		->select('select * from cmb_probability_contract`');

    	self::truncTable('client_statuses');

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

        return count($oldData);
    }

    public static function clientSources()
    {
    	$oldData = DB::connection('import')
    		->select('select * from cmb_clientfrom');

    	self::truncTable('client_sources');

    	foreach ($oldData as $key => $value) {

    		$row = [
    			'name' => $value->Value,
    			'sorting_num' => $value->SortID,
    		];

	        ClientSource::create($row);

    	};

        ClientSource::create(['name' => 'Источник не установлен', 'sorting_num' => 999999]);

        return count($oldData);
    }

    public static function productGroups()
    {
    	$oldData = DB::connection('import')
    		->select('select * from products_types');

    	self::truncTable('product_groups');

    	$i = 1;
        foreach ($oldData as $key => $value) {

    		$row = [
    			'name' => $value->name,
                'sorting_num' => $i * 10,
    		];

	        ProductGroup::create($row);
            $i++;
    	};

        return count($oldData);
    }

    public static function users()
    {
        $oldData = DB::connection('import')
            ->select('select * from users');

    	// Delete all users but admin
    	DB::statement('set foreign_key_checks = 0');
        DB::table('users')->where('id', '<>', config('import.admin_user_id', 1))->delete();
        DB::statement('set foreign_key_checks = 1'); 

        // Check email duplicates and make them unique
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
                'user_role_id' => config('import.manager_user_role_id', 2),
                'phone_number' => $value->phone_mobile,
                'birthday' => $value->birthday,
                'hired_date' => $value->work_start_date,
                'fired_date' => $value->work_end_date,
                'about' => $pass,
            ];

            User::create($row);

        };

        return count($oldData);
    }

    public static function clients()
    {
        // Compare the types of customers in old and new bases
        // and add value for no conformity
        $oldTypes = DB::connection('import')->select('select * from cmb_type');
        $typesMatch = [];
        foreach ($oldTypes as $oldType) {
            $typesMatch[$oldType->ID] = ClientType::where('name', $oldType->Value)->first()->id;
        }
        $typesMatch[-1] = ClientType::where('name', 'Тип не установлен')->first()->id;

        // Compare statuses
        $oldStatuses = DB::connection('import')
            ->select('select * from cmb_probability_contract');
        $statusesMatch = [];
        foreach ($oldStatuses as $oldStatus) {
            $statusesMatch[$oldStatus->ID] = ClientStatus::where('name', $oldStatus->Value)->first()->id;
        }
        $statusesMatch[-1] = ClientStatus::where('name', 'Статус не установлен')->first()->id;

        // Compare sources
        $oldSources = DB::connection('import')
            ->select('select * from cmb_clientfrom');
        $sourcesMatch = [];
        foreach ($oldSources as $oldSource) {
            $sourcesMatch[$oldSource->ID] = ClientSource::where('name', $oldSource->Value)->first()->id;
        }
        $sourcesMatch[-1] = ClientSource::where('name', 'Источник не установлен')->first()->id;

        // Compare users
        $oldUsers = DB::connection('import')
            ->select('select * from users');
        $usersMatch = [];
        foreach ($oldUsers as $oldUser) {
            $usersMatch[$oldUser->user_id] = User::where('name', $oldUser->name . ' ' . $oldUser->surname)->first()->id;
        }

        // Moving clients begins here
        $oldClients = DB::connection('import')->select('select * from clients');

        self::truncTable('clients');

        $clientsMatch = [];
        foreach ($oldClients as $oldClient) {

            // Change &quot; for "
            $oldClient->name = mb_ereg_replace('&quot;', '"', $oldClient->name);

            // Save inappropriate data into additional info field
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

            // Fill client data and insert to DB
            $row = [
                'name' => $oldClient->name,
                'client_type_id' => isset($typesMatch[$oldClient->cmb_type]) ? $typesMatch[$oldClient->cmb_type] : $typesMatch[-1],
                'client_status_id' => isset($statusesMatch[$oldClient->cmb_probability_contract]) ? $statusesMatch[$oldClient->cmb_probability_contract] : $statusesMatch[-1],
                'client_source_id' => isset($sourcesMatch[$oldClient->cmb_clientfrom]) ? $sourcesMatch[$oldClient->cmb_clientfrom] : $sourcesMatch[-1],
                'manager_user_id' => ($oldClient->UID > 0) ? $usersMatch[$oldClient->UID] : config('import.admin_user_id', 1),
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
                'created_by_user_id' => config('import.admin_user_id', 1),
                'created_at' => $oldClient->addition_date,
            ];

            $clientsMatch[$oldClient->client_id] = Client::create($row)->id;

        };

        // Fill old-new IDs table
        DB::table('client_old_new')->delete();
        foreach ($clientsMatch as $key => $value) {
            DB::table('client_old_new')->insert(
                ['old_client_id' => $key, 'new_client_id' => $value]
            );
        }

        return count($oldClients);

    }

    private static function truncTable($tbl)
    {
    	DB::statement('set foreign_key_checks = 0');
        DB::table($tbl)->truncate();
        DB::statement('set foreign_key_checks = 1');    	
    }

}