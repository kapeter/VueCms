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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',['middleware' => 'cors', 'namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {

	//Auth
	$api->post('/login', 'AuthController@login')->name('auth.login');
	$api->post('/logout', 'AuthController@logout')->name('auth.logout');

	//RBAC
	$api->resource('user','UserController');
	$api->resource('permission','PermissionController');
	$api->resource('role','RoleController');
	$api->post('role/build/{id}','RoleController@build');

	//profile
	$api->get('profile','UserController@profile')->name('profile.show');
	$api->post('profile','UserController@profile')->name('profile.update');

	//Post
	$api->resource('post','PostController');
	$api->post('post/{id}/change','PostController@change');

	//Category
	$api->resource('category','CategoryController');

	//Log
	$api->get('log','LogController@index')->name('log');

	//Media
	$api->get('media', 'MediaController@index')->name('media.list');
	$api->post('media', 'MediaController@upload')->name('media.upload');
	$api->delete('media', 'MediaController@delete')->name('media.delete');
	$api->post('folder', 'MediaController@create')->name('folder.create');

	//Setting
	$api->get('system', 'SettingController@system')->name('setting.system');
	$api->get('setting', 'SettingController@index')->name('setting.show');
	$api->post('setting', 'SettingController@store')->name('setting.store');

	//Mail
	$api->post('mail/send', 'MailController@send')->name('media.send');
});
