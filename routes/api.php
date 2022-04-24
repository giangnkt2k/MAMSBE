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
        Route::apiResource('client', 'ClientController');
        Route::post('building/delete', 'BuildingController@destroy');
        Route::post('building/import', 'BuildingController@import');
        Route::post('room/import', 'RoomController@import');
        Route::get('room/collectWater', 'RoomController@indexCollectWater');
        Route::get('room/collectElectric', 'RoomController@indexCollectElectric');
        Route::get('room/indexForBill', 'RoomController@indexForBill');
        Route::post('room/deleteImg', 'RoomController@deleteImg');
        Route::post('building/deleteImg', 'BuildingController@deleteImg');
        Route::apiResource('room', 'RoomController');
        Route::apiResource('contract', 'ContractController');
        Route::apiResource('rental', 'RentalController');
        Route::apiResource('water', 'WaterController');
        Route::apiResource('electric', 'ElectricController');
        Route::get('bill/indexByDate', 'BillController@indexByDate');
        Route::post('bill/addMany', 'BillController@addMany');

        Route::apiResource('bill', 'BillController');

        Route::post('client/import', 'ClientController@import');
        Route::post('client/deleteImg', 'ClientController@deleteImg');
        Route::post('client/importAva', 'ClientController@importAva');
        Route::post('client/deleteImgAva', 'ClientController@deleteImgAva');
        Route::post('image/edit/{id}', 'ImageController@update');
        Route::apiResource('image', 'ImageController');
        Route::get('sendBillEmail','RoomController@sendBillEmail');
        Route::get('sendBillSMS','RoomController@sendBillSMS');

        //dashboard
        Route::get('dashboard/clientsInBuilding', 'DashboardController@clientsInBuilding');
        Route::get('dashboard/roomStatus', 'DashboardController@roomStatus');
        Route::get('dashboard/indexNUmberByDateInBuilding', 'DashboardController@indexNUmberByDateInBuilding');
        Route::get('dashboard/listRoomNotPaied', 'DashboardController@listRoomNotPaied');
        Route::apiResource('dashboard', 'DashboardController');


    });
    Route::apiResource('city', 'CityController');
    Route::apiResource('roles', "RoleController")->middleware(['auth:user']);
    Route::get('permissions', 'RoleController@listPermission')->middleware(['auth:user']);

});

