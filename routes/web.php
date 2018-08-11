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


Route::get('/', ['uses'=>'ArticleController@datatable']);
Route::match(['get', 'post'],'/getposts', ['as'=>'datatable.getposts','uses'=>'ArticleController@getPosts']);

Route::resource('articles', 'ArticleController');

Route::post('/destroyAll', 'ArticleController@destroyAll');