<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/'], function ($app) {
	$app->post('login','AuthController@login');

	$app->group(['prefix' => 'users', 'middleware' => 'jwt.auth'], function ($app) {
		$app->get('/','AuthController@list');
		$app->post('detail','AuthController@detail');
		$app->post('create','AuthController@register');
		$app->post('update','AuthController@update');
		$app->post('delete','AuthController@delete');
		$app->get('trash','AuthController@trash');
		$app->post('change-password','AuthController@changePassword');
	});

	$app->group(['prefix' => 'customers', 'middleware' => 'jwt.auth'], function ($app) {
		$app->get('/','CustomerController@list');
		$app->post('detail','CustomerController@detail');
		$app->post('create','CustomerController@create');
		$app->post('update','CustomerController@update');
		$app->post('delete','CustomerController@delete');
		$app->get('trash','CustomerController@trash');
	});

	$app->group(['prefix' => 'vendors', 'middleware' => 'jwt.auth'], function ($app) {
		$app->get('/','VendorController@list');
		$app->post('detail','VendorController@detail');
		$app->post('create','VendorController@create');
		$app->post('update','VendorController@update');
		$app->post('delete','VendorController@delete');
		$app->get('trash','VendorController@trash');
	});

	$app->group(['prefix' => 'drivers', 'middleware' => 'jwt.auth'], function ($app) {
		$app->get('/','DriverController@list');
		$app->post('detail','DriverController@detail');
		$app->post('create','DriverController@create');
		$app->post('update','DriverController@update');
		$app->post('delete','DriverController@delete');
		$app->post('change-password','DriverController@changePassword');
		$app->get('trash','DriverController@trash');
	});

	$app->group(['prefix' => 'menus', 'middleware' => 'jwt.auth'], function ($app) {
		$app->get('/','MenuController@list');
		$app->post('detail','MenuController@detail');
		$app->post('create','MenuController@create');
		$app->post('update','MenuController@update');
		$app->post('delete','MenuController@delete');
		$app->get('trash','MenuController@trash');
	});

	$app->group(['prefix' => 'roles', 'middleware' => 'jwt.auth'], function ($app) {
		$app->get('/','RoleController@list');
		$app->post('detail','RoleController@detail');
		$app->post('create','RoleController@create');
		$app->post('update','RoleController@update');
		$app->post('delete','RoleController@delete');
		$app->get('trash','RoleController@trash');
	});

	$app->group(['prefix' => 'broadcasts', 'middleware' => 'jwt.auth'], function ($app) {
		$app->get('/','BroadcastController@list');
		$app->post('detail','BroadcastController@detail');
		$app->post('create','BroadcastController@create');
		$app->post('update','BroadcastController@update');
		$app->post('delete','BroadcastController@delete');
		$app->get('trash','BroadcastController@trash');
	});

	$app->group(['prefix' => 'trucks', 'middleware' => 'jwt.auth'], function ($app) {
		$app->get('/','TruckController@list');
		$app->post('detail','TruckController@detail');
		$app->post('create','TruckController@create');
		$app->post('update','TruckController@update');
		$app->post('delete','TruckController@delete');
		$app->get('trash','TruckController@trash');
	});
});