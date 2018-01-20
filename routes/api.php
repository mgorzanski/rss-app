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

Route::post('/article/{id}/save-for-later', 'ArticleController@saveForLater')->middleware('auth:api');
Route::post('/browse/load', 'LoadDataAjaxController@index')->middleware('auth:api');