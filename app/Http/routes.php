<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
}); 

Route::any('/wechat', 'WechatController@serve');

//Route::get('/images', 'MaterialController@image');

//Route::get('/material', 'MaterialController@material');  

Route::get('/users', 'UserController@getAllUsers');

Route::get('/menu', 'MenuController@menu');

Route::get('/menu/all', 'MenuController@all');

Route::get('/news', 'MessageController@getNews');

// Route::group(['middleware' => ['wechat.oauth:snsapi_base']], function () {
// 	Route::get('/view', function(){
// 		$user = session('wechat.oauth_user');

// 		return view('band', compact('user'));
// 	});
// });

