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

//Route::get('/', function () {
//    return view('welcome');
//});

//在之前的路由后面配上中间件
Route::get('/','PagesController@root')->name('root');

// 在之前的路由里加上一个verify参数
Auth::routes(['verify' => true]);
