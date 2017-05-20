<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::auth(); // laravel-adminlte hardcoded

Route::group(['middleware' => ['auth', 'web']], function () {

	Route::get('/', function () {
	    // return redirect('actions');
	    return redirect('client-sources');
	})->name('home');

	// Main page (laravel-adminlte hardcoded after-login redirect)
	Route::get('home', function () {
	    return redirect()->route('home');
	});

	// Actions
	Route::resource('actions', 'ActionsController', ['except' => ['show']]);

	// Clients
	Route::resource('clients', 'ClientsController');
	
	// Contact persons (no special crud UI for it)
	Route::post('clients/{id}/new-contact', 'ContactPersonsController@store');
	Route::get('contact-persons/{id}/delete', 'ContactPersonsController@destroy');
	Route::patch('contact-persons/{id}', 'ContactPersonsController@update');

	// Administrators area
	//
	//Route::group(['middleware' => 'admin'], function () {
	
		// Directories
		Route::resource('action-types', 'ActionTypesController', ['except' => ['show']]);
		Route::resource('client-types', 'ClientTypesController', ['except' => ['show']]);
		Route::resource('client-statuses', 'ClientStatusesController', ['except' => ['show']]);
		Route::resource('client-sources', 'ClientSourcesController', ['except' => ['show']]);
		Route::resource('product-groups', 'ProductGroupsController', ['except' => ['show']]);
		Route::resource('user-roles', 'UserRolesController', ['except' => ['show']]);

		// Users
		Route::resource('users', 'UsersController', ['except' => ['show']]);

		// Import
		Route::get('import', 'ImportController@index')->name('import');

	//});
	

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
