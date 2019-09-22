<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/dashboard/all', 'DashboardController@all')->name('dashboard');
    Route::get('/dashboard/view/{link}', 'DashboardController@view');
    Route::post('/dashboard/search', 'DashboardController@search');
    Route::delete('/dashboard/delete/{link}', 'DashboardController@delete');
});