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

    private static function truncTable($tbl)
    {
    	DB::statement('set foreign_key_checks = 0');
        DB::table($tbl)->truncate();
        DB::statement('set foreign_key_checks = 1');    	
    }
}