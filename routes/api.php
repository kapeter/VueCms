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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
	//User
	$api->group(['prefix' => 'users'], function($api){
		$api->get('/', 'App\Http\Controllers\Api\V1\UserController@index');
		$api->get('/{user}', 'App\Http\Controllers\Api\V1\UserController@show');
	});

	//Post
	$api->group(['prefix' => 'posts'], function($api){
		$api->get('/', 'App\Http\Controllers\Api\V1\PostController@index');
		$api->get('/{post}', 'App\Http\Controllers\Api\V1\PostController@show');
	});

});
