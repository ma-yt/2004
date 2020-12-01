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

//路由分组
Route::prefix('/test')->group(function(){
    Route::get('/test1','Test\TestController@test');
    Route::get('/test2','Test\TestController@info');
    Route::get('/test3','Test\TestController@abc');
    Route::post('/test4','Test\TestController@aaa');
    Route::get('/guzzle','Test\TestController@guzzle');
    Route::any('/guzzle2','Weixin\IndexController@guzzle2');
});


Route::prefix('/weixin')->group(function(){
    Route::any('/jieru','Weixin\IndexController@jieru');
    Route::any('/','Weixin\IndexController@event');  //微信推送事件
    Route::any('/token','Weixin\IndexController@gettoken');  //调用token
    Route::post('/menu','Weixin\IndexController@menu');  //自定义菜单
    Route::get('/media','Weixin\IndexController@media');  //临时素材
});
