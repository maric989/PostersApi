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
Route::get('/users','UserController@index');

Route::post('/register','RegisterController@register');



Route::group(['prefix' => 'post'],function(){

    Route::post('/','PostController@store')->middleware('auth:api');
    Route::get('/','PostController@index');
    Route::get('/{id}','PostController@show');
    Route::delete('/{id}','PostController@destroy')->middleware('auth:api');
    Route::patch('/{id}','PostController@update')->middleware('auth:api');
    Route::post('{id}/comment','CommentController@store')->middleware('auth:api');
});


