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

Route::middleware('auth:api')->get('/profile', 'Api\ProfileController@getUser');
Route::middleware('auth:api')->resource('/articles', 'Api\ArticlesController');
Route::middleware('auth:api')->post('/articles/preview', 'Api\ArticlesController@preview');