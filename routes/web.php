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

Route::get('/', 'HomeController@index');

Route::get('/browse/feeds', 'SubscriptionController@index');
Route::post('/browse/feeds', 'SubscriptionController@manage');
Route::get('/browse/article/{id}', 'ArticleController@read');
Route::get('/login', 'LoginController@index');
Route::get('/logout', 'LoginController@logout');
Route::post('/login', 'LoginController@authenticate');
Route::post('/register', 'LoginController@register');
Route::post('/browse/load', 'HomeController@loadDataAjax');
Route::get('/browse/subscription/{id}', 'SubscriptionController@browse');
Route::post('/browse/load-subscription', 'SubscriptionController@loadDataAjax');
Route::get('/search', 'SearchController@query');