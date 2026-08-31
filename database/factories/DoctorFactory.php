<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [

            /*
            |--------------------------------------------------------------------------
            | User Account
            |--------------------------------------------------------------------------
            */

            'user_id' => User::factory()->state([

                'name' =>
                    $firstName . ' ' . $lastName,

                'email' =>
                    fake()->unique()->safeEmail(),

            ]),


            /*
            |--------------------------------------------------------------------------
            | Doctor Information
            |--------------------------------------------------------------------------
            */

            'doctor_id' =>
                'DOC' . fake()->unique()->numerify('#####'),

            'specialization' =>
                fake()->randomElement([

                    'Cardiology',

                    'General Medicine',

                    'Neurology',

                    'Pediatrics',

                    'Orthopedics',

                    'Dermatology',

                    'Psychiatry',

                    'Radiology',

                    'Oncology',

                    'Emergency Medicine',

                ]),

            'phone' =>
                '+60' . fake()->numerify('1########'),

        ];
    }
}
 