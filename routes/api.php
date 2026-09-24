<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DeviceController;


/*
|--------------------------------------------------------------------------
| ESP32 DEVICE PAIRING API
|--------------------------------------------------------------------------
|
| These routes are used before the ESP32 has a permanent token.
|
*/

Route::post('/device/pair/request', [
    DeviceController::class,
    'pairRequest'
]);

Route::get('/device/pair/status', [
    DeviceController::class,
    'pairStatus'
]);


/*
|--------------------------------------------------------------------------
| AUTHENTICATED DOCTOR API
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Current logged-in user
    |--------------------------------------------------------------------------
    */

    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    /*
    |--------------------------------------------------------------------------
    | Device management
    |--------------------------------------------------------------------------
    */

    Route::get('/devices', [
        DeviceController::class,
        'index'
    ]);

    Route::post('/devices', [
        DeviceController::class,
        'register'
    ]);

    Route::get('/devices/{deviceId}', [
        DeviceController::class,
        'show'
    ]);

    Route::put('/devices/{deviceId}', [
        DeviceController::class,
        'update'
    ]);

    Route::delete('/devices/{deviceId}', [
        DeviceController::class,
        'destroy'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Device readings
    |--------------------------------------------------------------------------
    */

    Route::get('/devices/{deviceId}/readings', [
        DeviceController::class,
        'readings'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Approve ESP32 pairing
    |--------------------------------------------------------------------------
    */

    Route::post('/device/pair/approve', [
        DeviceController::class,
        'pairApprove'
    ]);
});


/*
|--------------------------------------------------------------------------
| ESP32 SENSOR API
|--------------------------------------------------------------------------
|
| These routes require the permanent device authentication token.
|
*/

Route::middleware('device.auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Store sensor reading
    |--------------------------------------------------------------------------
    */

    Route::post('/device/readings', [
        DeviceController::class,
        'storeReading'
    ]);

});