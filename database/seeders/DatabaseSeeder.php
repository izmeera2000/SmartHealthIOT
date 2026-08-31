<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $user = User::factory()->create([
            'name' => 'Test Doctor',
            'email' => 'doctor@example.com',
            'password' => Hash::make('123'),
        ]);
        $user->assignRole('doctor');


                $user2 = User::factory()->create([
            'name' => 'Patient',
            'email' => 'patient@example.com',
            'password' => Hash::make('123'),
        ]);
        $user2->assignRole('patient');


                Patient::factory()->count(30)->create();
                Doctor::factory()->count(30)->create();

    }
}