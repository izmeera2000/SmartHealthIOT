<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceWebController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientUserController;
use App\Http\Controllers\BeamsTestController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    |
    | Both doctor and patient use:
    |
    | /dashboard
    |
    | The view is selected based on the user's role.
    |
    */

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | DOCTOR
    |--------------------------------------------------------------------------
    |
    | Doctor pages:
    |
    | /patients
    | /devices
    | /alerts
    |
    */

    Route::middleware('role:doctor')->name('doctor.')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Patients
        |--------------------------------------------------------------------------
        */




        Route::prefix('patients')
            ->name('patients.')
            ->group(function () {

                // Page
                Route::get('/', [
                    PatientController::class,
                    'index'
                ])->name('index');

                // JSON data for DataTables
                Route::get('/data', [
                    PatientController::class,
                    'data'
                ])->name('data');

                // Create
                Route::get('/create', [
                    PatientController::class,
                    'create'
                ])->name('create');

                Route::post('/', [
                    PatientController::class,
                    'store'
                ])->name('store');

                // Show
                Route::get('/{patient}', [
                    PatientController::class,
                    'show'
                ])->name('show');

                // Edit
                Route::get('/{patient}/edit', [
                    PatientController::class,
                    'edit'
                ])->name('edit');

                Route::put('/{patient}', [
                    PatientController::class,
                    'update'
                ])->name('update');


                Route::delete('/{patient}', [
                    PatientController::class,
                    'destroy'
                ])->name('destroy');


            });



        /*
        |--------------------------------------------------------------------------
        | Devices
        |--------------------------------------------------------------------------
        */

        Route::prefix('doctor/devices')
            ->name('devices.')
            ->group(function () {

                Route::get('/', [DeviceWebController::class, 'index'])
                    ->name('index');
 

                Route::get('/data', [DeviceWebController::class, 'data'])
                    ->name('data');

                Route::get('/create', [DeviceWebController::class, 'create'])
                    ->name('create');

                Route::post('/', [DeviceWebController::class, 'store'])
                    ->name('store');

                Route::get('/{device}/edit', [DeviceWebController::class, 'edit'])
                    ->name('edit'); 

                Route::get('/{device}/readings', [DeviceWebController::class, 'readings'])
                    ->name('readings');

                Route::get('/{device}', [DeviceWebController::class, 'show'])
                    ->name('show');

                Route::put('/{device}', [DeviceWebController::class, 'update'])
                    ->name('update');

                Route::delete('/{device}', [DeviceWebController::class, 'destroy'])
                    ->name('destroy');
            });



        /*
         |--------------------------------------------------------------------------
         | Doctors
         |--------------------------------------------------------------------------
         */

        Route::prefix('doctors')
            ->name('doctors.')
            ->group(function () {

                // Page
                Route::get('/', [
                    DoctorController::class,
                    'index'
                ])->name('index');

                // JSON data for DataTables
                Route::get('/data', [
                    DoctorController::class,
                    'data'
                ])->name('data');

                // Create
                Route::get('/create', [
                    DoctorController::class,
                    'create'
                ])->name('create');

                Route::post('/', [
                    DoctorController::class,
                    'store'
                ])->name('store');

                // Show
                Route::get('/{doctor}', [
                    DoctorController::class,
                    'show'
                ])->name('show');

                // Edit
                Route::get('/{doctor}/edit', [
                    DoctorController::class,
                    'edit'
                ])->name('edit');

                Route::put('/{doctor}', [
                    DoctorController::class,
                    'update'
                ])->name('update');


                Route::delete('/{doctor}', [
                    DoctorController::class,
                    'destroy'
                ])->name('destroy');

            });




    });




    Route::middleware('role:patient')
        ->name('patient.')
        ->group(function () {

            // Devices
            Route::get('/devices', [
                PatientUserController::class,
                'devices'
            ])->name('devices');

            // Readings for selected device
            Route::get('/devices/{device}/readings', [
                PatientUserController::class,
                'readings'
            ])->name('devices.readings');

            // DataTables AJAX endpoint 
            Route::get('/devices/{device}/readings-data', [
                PatientUserController::class,
                'readingsData'
            ])->name('devices.readings.data');

        });


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'index'
    ])->name('profile.index');

    Route::get('/profile/edit', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');


    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');


    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');

    Route::get('/notifications', [
        NotificationController::class,
        'index'
    ])->name('notifications.index');

    Route::post('/notifications/{id}/read', [
        NotificationController::class,
        'markAsRead'
    ])->name('notifications.read');

    Route::post('/notifications/read-all', [
        NotificationController::class,
        'markAllAsRead'
    ])->name('notifications.readAll');

});


Route::get('/speed-test', function () {
    return 'OK';
});

Route::prefix('test-errors')->group(function () {

    Route::get('/403', function () {
        abort(403);
    });

    Route::get('/404', function () {
        abort(404);
    });



    Route::get('/500', function () {
        abort(500);
    });


    // Coming Soon
    Route::get('/coming-soon', function () {
        return view('errors.comingsoon');
    });
});



Route::view('/about', 'pages.about')->name('about');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/contact', 'pages.contact')->name('contact');
/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';