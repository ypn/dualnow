<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/','Controller@home');


Route::group(['middleware'=>'authenticate'],function(){	
	Route::get('settings','Controller@edit');
	Route::post('update','Auth\LoginController@update');
	Route::get('messages/detail/{alias}','Auth\LoginController@conversation');
	Route::get('messages/inbox','Auth\LoginController@inbox');
	Route::get('messages/send','Auth\LoginController@send');
	Route::post('messages/delete-send','Auth\LoginController@deletesend');
	Route::post('messages/delete-inbox','Auth\LoginController@deleteInbox');
	Route::get('messages/read/{sender_alias}/{rid}/{message_id}','Auth\LoginController@readMessage');
	Route::get('compose','Auth\LoginController@compose');
	Route::post('send_message','Auth\LoginController@sendMessage');

	Route::get('notifications/read','Auth\LoginController@readNotification');
	Route::get('notifications/handler/accept','Auth\LoginController@accept');
	Route::get('notifications/delete','Auth\LoginController@deleteNotification');
	Route::post('post-chat','Auth\LoginController@postChat');

});

Route::get('curl','Controller@curl');
Route::get('html','Controller@htmlDOM');
Route::get('list_champs','Controller@listChamps');
Route::post('login','Auth\LoginController@handleLogin');
Route::post('register','Auth\RegisterController@create');
Route::get('loginfb','Auth\RegisterController@loginFb');
Route::get('logout','Auth\LoginController@handleLogout');
Route::get('friend-ship','Controller@updateFriend');
Route::get('summoner/{alias}','Controller@profile');
Route::get('filter','Controller@home');
Route::post('/','Controller@home');
Route::get('download-mod-skin-lol','Controller@downloadmodskin');
Route::get('download-now','Controller@downloadnow');
Route::get('notification','Auth\LoginController@pusher');
Route::get('dieu-khoan-su-dung','Auth\LoginController@license');
Route::get('get-notices','Auth\LoginController@getNotices');
Route::get('room-chat','Auth\LoginController@chat');
Route::get('fb-login','Auth\LoginController@loginFb');
Route::get('fb-callback','Auth\LoginController@fbCallback');

Route::get('postfb','Auth\LoginController@postFb');
Route::get('posts','Controller@posts');
Route::get('funny','Controller@funnyapp');
Route::get('bomaylaadmin','Controller@admin');
Route::get('infinity','Controller@infinity');