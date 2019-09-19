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
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware('auth');
Route::delete('/dashboard/delete/{link}', 'DashboardController@delete')->middleware('auth');
Route::get('/dashboard/view/{link}', 'DashboardController@view')->middleware('auth');
Route::post('/dashboard/search', 'DashboardController@search')->middleware('auth');

Route::post('/links', 'LinkController@store');
Route::get('/{short_tag}', 'LinkController@get');