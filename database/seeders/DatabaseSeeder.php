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

        $user->assignRole('doctor');

        // Test Patient User
        $user2 = User::factory()->create([
            'name' => 'Patient',
            'email' => 'patient@example.com',
            'password' => Hash::make('123'),
        ]);

        $user2->assignRole('patient');

        // Create Patients
        Patient::factory()
            ->count(5)
            ->create();

        // Create Doctors
        Doctor::factory()
            ->count(10)
            ->create();

        // Create 30 Devices for Test Doctor only
        Device::factory()
            ->count(5)
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