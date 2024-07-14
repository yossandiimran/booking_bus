<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('API')->group(function () {
    Route::post('login', 'AuthController@login')->name('auth.login');
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('logout', 'AuthController@logout')->name('auth.logout');
    });
});