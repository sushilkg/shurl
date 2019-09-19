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
    return view('app');
});

Route::get('/login', function () {
    return view('app');
});

Route::get('/dashboard', function () {
    return view('app');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard/all', 'DashboardController@all')->name('dashboard');
    Route::delete('/dashboard/delete/{link}', 'DashboardController@delete');
    Route::get('/dashboard/view/{link}', 'DashboardController@view');
    Route::post('/dashboard/search', 'DashboardController@search');
});

Route::post('/links', 'LinkController@store');
Route::get('/{short_tag}', 'LinkController@get');