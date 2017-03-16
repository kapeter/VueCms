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

Route::middleware('jwt.auth')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
	//Auth
	$api->post('/login', 'Auth\LoginController@login');
	$api->post('/logout', 'Auth\LoginController@logout');

	//User
	$api->group(['prefix' => 'users'], function($api){
		$api->get('/', 'UserController@index');
		$api->get('/{user}', 'UserController@show');
	});
	
	//Post
	$api->resource('post','PostController');

});
