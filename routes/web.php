<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;

Route::get('/', function () {
    return view('welcome');
});




Route::post('/device/register', [DeviceController::class, 'register']);
Route::post('/device/status', [DeviceController::class, 'status']);
Route::post('/device/data', [DeviceController::class, 'storeData']);
Route::post('/device/sos', [DeviceController::class, 'sos']);