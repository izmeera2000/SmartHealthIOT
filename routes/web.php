<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

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

                Route::get('/', function () {
                    return view('doctor.devices.index');
                })->name('index');

            });


        /*
         |--------------------------------------------------------------------------
         | Doctors
         |--------------------------------------------------------------------------
         */

        Route::prefix('doctors')
            ->name('doctors.')
            ->group(function () {

                Route::get('/', function () {
                    return view('doctor.doctors.index');
                })->name('index');

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