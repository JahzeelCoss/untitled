<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect()->action('Auth\AuthController@getLogin');
});

Route::get('/home', function () {
    return redirect('/travels');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::post('travels/{id}/excel', 'TravelController@excel');
Route::get('travels/changestatus/{status}/{travel}', 'TravelController@changeStatus');
Route::resource('travels', 'TravelController');

//Route routes
Route::get('routes/searchlocation', 'LocationController@getLocation');
Route::post('routes/searchroute', 'RouteController@getRoute');
Route::resource('routes', 'RouteController');


Route::resource('locations', 'LocationController');


Route::get('cars/searchcar', 'CarController@getCar');
Route::resource('cars', 'CarController');

Route::resource('roles', 'RoleController');

Route::resource('gas', 'GasController');

//Permissions
Entrust::routeNeedsRole('roles*', 'admin', Redirect::to('/locations'));

//reports
Route::post('travels/{id}/excel', 'TravelController@excel');
Route::get('travels/changestatus/{status}/{travel}', 'TravelController@changeStatus');


Route::get('/', function () {
    return redirect()->action('Auth\AuthController@getLogin');
});

Route::get('/home', function () {
    return redirect('/travels');
});


Route::get('/reports', 'ReportGeneratorController@viewReport');
Route::post('/reports', 'ReportGeneratorController@setReportDetails');
Route::post('reports/excel', 'ReportGeneratorController@excel');

