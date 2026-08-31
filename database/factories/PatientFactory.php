<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [
        'doctor_id' => User::role('doctor')
                ->inRandomOrder()
                ->value('id'),

            'user_id' => User::factory()->create([
                'name' => $firstName . ' ' . $lastName,
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password'),
            ]),

            'patient_id' => 'PT-' . strtoupper(Str::random(8)),

            'ic_number' => fake()->numerify('############'),

            'date_of_birth' => fake()->dateTimeBetween(
                '-80 years',
                '-18 years'
            )->format('Y-m-d'),

            'gender' => fake()->randomElement([
                'male',
                'female',
            ]),

            'phone' => '01' . fake()->numerify('########'),

            'address' => fake()->address(),

            'emergency_contact_name' => fake()->name(),

            'emergency_contact_phone' => '01' . fake()->numerify('########'),

            'emergency_contact_relationship' => fake()->randomElement([
                'Father',
                'Mother',
                'Spouse',
                'Sibling',
                'Child',
            ]),

            'blood_type' => fake()->randomElement([
                'A+',
                'A-',
                'B+',
                'B-',
                'AB+',
                'AB-',
                'O+',
                'O-',
            ]),

            'height' => fake()->randomFloat(2, 150, 195),

            'weight' => fake()->randomFloat(2, 45, 120),
        ];
    }
}