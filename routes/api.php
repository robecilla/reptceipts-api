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

// Declares register, log in, log out and password reset routes
//Route::auth(); TODO: decide if use this shorcut

// Declares crud routes (GET,POST,PUT/PATCH,DELETE)

Route::post("login", "AuthController@login");
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::resource('receipt', 'ReceiptController');
    Route::get('receipt/getDetail/{id}', 'ReceiptController@getDetail');
    Route::resource('user', 'UserController');
});
