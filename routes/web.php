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

Route::get('/{short_tag}', 'LinkController@get');