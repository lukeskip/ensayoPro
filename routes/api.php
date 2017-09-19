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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::get('logout', 'Auth\LoginController@logout');

// Route::group(['middleware' => 'auth:api'], function()
// {
//     Route::resource('v1/users', 'v1\UserController');
// });

Route::group([
  'prefix' => 'v1',
  'namespace' => 'v1'
], function () {
  Route::post('/auth/register', [
    'as' => 'auth.register',
    'uses' => 'AuthController@register'
  ]);
  Route::post('/auth/login', [
    'as' => 'auth.login',
    'uses' => 'AuthController@login'
  ]);
});