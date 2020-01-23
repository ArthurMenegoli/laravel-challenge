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



Route::namespace('Api')->group(function() {    
    Route::get('/events', 'EventController@index');
    Route::post('/events/new', 'EventController@store');
    Route::get('/events/upcoming', 'EventController@upcomingEvents');
    Route::get('/events/today', 'EventController@todayEvents');
    Route::put('/events/{id}', 'EventController@update');
    Route::delete('/events/{id}', 'EventController@destroy');    
});