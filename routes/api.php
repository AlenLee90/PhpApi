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

Route::group(['prefix' => '/cooper'], function () {  
    Route::resource('user', 'UserController');
});

Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');
/*
Route::post('details', 'PassportController@getDetails');
*/

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('details', 'PassportController@getDetails');
});
