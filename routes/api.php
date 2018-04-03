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

Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::resource('receipt', 'ReceiptController');
    Route::post('receipt/userReceipts', 'ReceiptController@getReceiptsByUserID');
    Route::get('user/JWTuser', 'UserController@JWTuser');
    Route::resource('user', 'UserController');
    Route::resource('retailer', 'RetailerController');
});
