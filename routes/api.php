<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SensorReadingController;


/*
|--------------------------------------------------------------------------
| ESP32 DEVICE PAIRING API
|--------------------------------------------------------------------------
|
| These routes are used by a brand-new ESP32 before it has a
| permanent device token.
|
*/


// ESP32 announces itself and provides its 6-digit pairing code
Route::post('/device/pair/request', [
    DeviceController::class,
    'pairRequest'
]);


// ESP32 repeatedly checks whether the doctor has approved it
Route::get('/device/pair/status', [
    DeviceController::class,
    'pairStatus'
]);


/*
|--------------------------------------------------------------------------
| AUTHENTICATED DOCTOR API
|--------------------------------------------------------------------------
|
| These routes require a logged-in doctor.
|
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
    | APPROVE ESP32 PAIRING
    |--------------------------------------------------------------------------
    |
    | Doctor enters the 6-digit code shown on the ESP32.
    |
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
| These routes require the permanent device token.
|
| The ESP32 only reaches these AFTER registration.
|
*/

Route::middleware('device.auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Send sensor reading
    |--------------------------------------------------------------------------
    */

    Route::post('/device/readings', [
        SensorReadingController::class,
        'store'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Latest sensor reading
    |--------------------------------------------------------------------------
    */

    Route::get('/device/readings/latest', [
        SensorReadingController::class,
        'latest'
    ]);
});