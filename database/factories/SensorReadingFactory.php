<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\SensorReading;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SensorReading>
 */
class SensorReadingFactory extends Factory
{
    protected $model = SensorReading::class;

    public function definition(): array
    {
        return [
            'device_id' => Device::factory(),

            'heart_rate' => fake()->numberBetween(60, 100),

            'spo2' => fake()->numberBetween(95, 100),

            'body_temperature' => fake()->randomFloat(
                2,
                36.0,
                37.5
            ),

            'ambient_temperature' => fake()->randomFloat(
                2,
                22.0,
                32.0
            ),

            'battery_level' => fake()->numberBetween(20, 100),

            'recorded_at' => fake()->dateTimeBetween(
                '-7 days',
                'now'
            ),
        ];
    }


}