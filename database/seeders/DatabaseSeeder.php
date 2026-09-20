<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Patient;
use App\Models\Device;
use App\Models\SensorReading;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Roles & Permissions
        |--------------------------------------------------------------------------
        */

        $this->call(RolePermissionSeeder::class);


        /*
        |--------------------------------------------------------------------------
        | Test Doctor User
        |--------------------------------------------------------------------------
        */

        $doctorUser = User::factory()->create([
            'name' => 'Test Doctor',
            'email' => 'doctor@example.com',
            'password' => Hash::make('123'),
        ]);

        $doctorUser->assignRole('doctor');


        /*
        |--------------------------------------------------------------------------
        | Doctor Profile
        |--------------------------------------------------------------------------
        */

        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'doctor_id' => 'DOC-0001',
            'specialization' => 'General Medicine',
            'phone' => '0123456789',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Test Patient User
        |--------------------------------------------------------------------------
        */

        $patientUser = User::factory()->create([
            'name' => 'Patient',
            'email' => 'patient@example.com',
            'password' => Hash::make('12345678'),
        ]);

        $patientUser->assignRole('patient');


        /*
        |--------------------------------------------------------------------------
        | Patient Profile
        |--------------------------------------------------------------------------
        */

        $patient = Patient::create([
            'user_id' => $patientUser->id,

            // Doctor relationship
            'doctor_id' => $doctorUser->id,

            'patient_id' => 'PAT-0001',
            'ic_number' => '900101-10-1234',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'phone' => '0123456789',
            'address' => 'Kuala Lumpur, Malaysia',

            'emergency_contact_name' => 'Emergency Contact',
            'emergency_contact_phone' => '01123456789',

            'blood_type' => 'O+',
            'height' => 175,
            'weight' => 70,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Additional Patients
        |--------------------------------------------------------------------------
        */

        Patient::factory()
            ->count(5)
            ->create()
            ->each(function ($patient) {

                $patient->user->assignRole('patient');

            });


        /*
        |--------------------------------------------------------------------------
        | Additional Doctors
        |--------------------------------------------------------------------------
        */

        Doctor::factory()
            ->count(10)
            ->create()
            ->each(function ($doctor) {

                $doctor->user->assignRole('doctor');

            });


        /*
        |--------------------------------------------------------------------------
        | Devices For Test Doctor
        |--------------------------------------------------------------------------
        */

        Device::factory()
            ->count(4)
            ->forDoctor($doctorUser)
            ->create();


        /*
        |--------------------------------------------------------------------------
        | Device For Test Patient
        |--------------------------------------------------------------------------
        */

        $patientDevice = Device::factory()
            ->forPatient($patient)
            ->forDoctor($doctorUser)
            ->create();


        /*
        |--------------------------------------------------------------------------
        | Sensor Readings
        |--------------------------------------------------------------------------
        |
        | Create readings for every device belonging to the test doctor.
        |
        */

        Device::where('doctor_id', $doctorUser->id)
            ->get()
            ->each(function ($device) {

                SensorReading::factory()
                    ->count(50)
                    ->create([
                        'device_id' => $device->id,
                    ]);

            });
    }
}