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
        // Roles & permissions
        $this->call(RolePermissionSeeder::class);
        // Test Doctor User
        $user = User::factory()->create([
            'name' => 'Test Doctor',
            'email' => 'doctor@example.com',
            'password' => Hash::make('123'),
        ]);

        // Assign Spatie role
        $user->assignRole('doctor');

        // Create Doctor profile
        $doctor = Doctor::create([
            'user_id' => $user->id,
            'doctor_id' => 'DOC-0001',
            'specialization' => 'General Medicine',
            'phone' => '0123456789',
        ]);
        // Test Patient User
        $user2 = User::factory()->create([
            'name' => 'Patient',
            'email' => 'patient@example.com',
            'password' => Hash::make('12345678'),
        ]);

        $user2->assignRole('patient');

        // Create Patient record
        $patient = Patient::create([
            'user_id' => $user2->id,
            'doctor_id' => $user->id,

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
        // Create Patients
        Patient::factory()
            ->count(5)
            ->create()
            ->each(function ($patient) {
                $patient->user->assignRole('patient');
            });

        // Create Doctors
        Doctor::factory()
            ->count(10)
            ->create()
            ->each(function ($doctor) {
                $doctor->user->assignRole('doctor');
            });
        // Create 30 Devices for Test Doctor only
        Device::factory()
            ->count(4)
            ->forDoctor($user)
            ->create();


            
            $device = Device::factory()
    ->forPatient($patient)
            ->forDoctor($user)

    ->create();

        // Create 50 sensor readings for each device
        Device::where('doctor_id', $user->id)
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