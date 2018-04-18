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

Route::get('/', function () {
    return redirect('/check-hours');
});

Route::get('employees', 'EmployeesController@hoursForm');
Route::view('check-hours', 'check_hours');

Route::get('check-hours/{days}', 'TimeIntervalsController@index')
	->where('days', '[0-9]+');
Route::post('time-intervals', 'TimeIntervalsController@storeOrUpdate');