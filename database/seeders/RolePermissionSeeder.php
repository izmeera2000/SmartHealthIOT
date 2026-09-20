<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $admin = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        $doctor = Role::firstOrCreate([
            'name' => 'doctor',
        ]);

        $patient = Role::firstOrCreate([
            'name' => 'patient',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        // Patients
        $viewPatients = Permission::firstOrCreate([
            'name' => 'view patients',
        ]);

        $managePatients = Permission::firstOrCreate([
            'name' => 'manage patients',
        ]);


        // Devices
        $viewDevices = Permission::firstOrCreate([
            'name' => 'view devices',
        ]);

        $manageDevices = Permission::firstOrCreate([
            'name' => 'manage devices',
        ]);

        $viewOwnDevices = Permission::firstOrCreate([
            'name' => 'view own devices',
        ]);


        // Sensor Readings
        $viewSensorReadings = Permission::firstOrCreate([
            'name' => 'view sensor readings',
        ]);

        $manageSensorReadings = Permission::firstOrCreate([
            'name' => 'manage sensor readings',
        ]);

        $viewOwnSensorReadings = Permission::firstOrCreate([
            'name' => 'view own sensor readings',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Admin Permissions
        |--------------------------------------------------------------------------
        */

        $admin->syncPermissions([
            $viewPatients,
            $managePatients,

            $viewDevices,
            $manageDevices,

            $viewSensorReadings,
            $manageSensorReadings,

            $viewOwnDevices,
            $viewOwnSensorReadings,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Doctor Permissions
        |--------------------------------------------------------------------------
        */

        $doctor->syncPermissions([
            $viewPatients,
            $managePatients,

            $viewDevices,
            $manageDevices,

            $viewSensorReadings,
            $manageSensorReadings,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Patient Permissions
        |--------------------------------------------------------------------------
        */

        $patient->syncPermissions([
            $viewOwnDevices,
            $viewOwnSensorReadings,
        ]);
    }
}
