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
	Route::post('getViewDatas', 'ViewController@getViewDatas');
});

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('getViewDetail', 'ViewController@getViewDetail');
});

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('updateViewDetail', 'ViewController@updateViewDetail');
});

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('deleteViewData', 'ViewController@deleteViewData');
});

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('getChartTodaySum', 'ViewController@getChartTodaySum');
});

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('getChartRec14DaysDatas', 'ViewController@getChartRec14DaysDatas');
});

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('getChartRec3MonsDatas', 'ViewController@getChartRec3MonsDatas');
});

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('updateInputDetail', 'InputDataController@updateInputDetail');
});
