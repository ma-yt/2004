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
    phpinfo();
});

Route::get('/test','Test\TestController@test');
Route::get('/test2','Test\TestController@info');
Route::get('/test3','Test\TestController@abc');

Route::any('/weixin','Weixin\IndexController@event');  //微信推送事件
Route::any('/weixin/token','Weixin\IndexController@gettoken');  //调用token