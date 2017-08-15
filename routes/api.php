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

$api->version('v1',['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
	//Auth
	$api->post('/login', 'Auth\LoginController@login');
	$api->post('/logout', 'Auth\LoginController@logout');

	//RBAC
	$api->resource('user','UserController');
	$api->resource('permission','PermissionController');
	$api->resource('role','RoleController');
	$api->post('role/build/{id}','RoleController@build');

	//profile
	$api->get('profile','UserController@profile');
	$api->post('profile','UserController@profile');

	//Post
	$api->resource('post','PostController');
	$api->post('post/{id}/change','PostController@change');

	//Category
	$api->resource('category','CategoryController');

	//Log
	$api->get('log','LogController@index');

	//Media
	$api->get('media', 'MediaController@index');
	$api->post('media/create', 'MediaController@create');
	$api->get('media/folders', 'MediaController@folders');
	$api->post('media/upload', 'MediaController@upload');
	$api->post('media/delete', 'MediaController@delete');
	$api->get('media/download', 'MediaController@download');
});
