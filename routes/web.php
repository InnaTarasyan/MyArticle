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
    return view('welcome');
});

//Route::get('/data', function () {
//    return View::make('article.index');
//});

Route::get('datatable', ['uses'=>'ArticleController@datatable']);
Route::get('datatable/getposts', ['as'=>'datatable.getposts','uses'=>'ArticleController@getPosts']);