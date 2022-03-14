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

Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('remind-password', 'AuthController@remindPassword');
    });
    Route::group(['middleware' => 'auth:user'], function(){
        Route::group(['prefix' => 'auth'], function () {
            Route::post('refresh', 'AuthController@refresh');
        });
        Route::get('profile', 'AuthController@getProfile');
        Route::put('profile', 'AuthController@update');
        Route::apiResource('user', 'UserController');
        Route::apiResource('setting', 'SettingController');
        Route::apiResource('blog', 'BlogController');
        Route::apiResource('building', 'BuildingController');
        Route::post('building/delete', 'BuildingController@destroy');
        Route::post('building/import', 'BuildingController@import');
        Route::post('building/deleteImg', 'BuildingController@deleteImg');
        Route::apiResource('room', 'RoomController');
        Route::post('image/edit/{id}', 'ImageController@update');
        Route::apiResource('image', 'ImageController');

    });
    Route::apiResource('city', 'CityController');
    Route::apiResource('roles', "RoleController")->middleware(['auth:user']);
    Route::get('permissions', 'RoleController@listPermission')->middleware(['auth:user']);

});

