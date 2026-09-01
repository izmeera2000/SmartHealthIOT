<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceWebController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\BeamsTestController;

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

    Route::get('/', function () {

        $user = auth()->user();

        if ($user->hasRole('doctor')) {
            return view('doctor.dashboard');
        }

        if ($user->hasRole('patient')) {
            return view('patient.dashboard');
        }

        // if ($user->hasRole('admin')) {
        //     return view('admin.dashboard');
        // }

        abort(403, 'Unauthorized role.');

    })->name('dashboard');



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

        Route::prefix('devices')
            ->name('devices.')
            ->group(function () {

          

                       // Page
                Route::get('/', [
                    DeviceWebController::class,
                    'index'
                ])->name('index');

                

                // JSON data for DataTables
                Route::get('/data', [
                    DeviceWebController::class,
                    'data'
                ])->name('data');

                // Create
                Route::get('/create', [
                    DeviceWebController::class,
                    'create'
                ])->name('create');

                    

                Route::post('/', [
                    DeviceWebController::class,
                    'store'
                ])->name('store');

                // Show
                Route::get('/{device}', [
                    DeviceWebController::class,
                    'show'
                ])->name('show');

                // Edit
                Route::get('/{device}/edit', [
                    DeviceWebController::class,
                    'edit'
                ])->name('edit');

                Route::put('/{device}', [
                    DeviceWebController::class,
                    'update'
                ])->name('update');


        Route::get('/{device}/readings', [
                    DeviceWebController::class,
                    'readings'
                ])->name('readings');

                Route::delete('/{device}', [
                    DeviceWebController::class,
                    'destroy'
                ])->name('destroy');




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
                Route::get('/{patient}', [
                    DoctorController::class,
                    'show'
                ])->name('show');

                // Edit
                Route::get('/{patient}/edit', [
                    DoctorController::class,
                    'edit'
                ])->name('edit');

                Route::put('/{patient}', [
                    DoctorController::class,
                    'update'
                ])->name('update');


                Route::delete('/{patient}', [
                    DoctorController::class,
                    'destroy'
                ])->name('destroy');

            });




    });




    Route::middleware('role:patient')->name('patient.')->group(function () {




    });


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
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

});





/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';