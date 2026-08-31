<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Device>
 */
class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'doctor_id' => User::factory(),

            'device_uid' => 'ESP32-' . strtoupper(Str::random(10)),

            'mac_address' => fake()->unique()->macAddress(),

            'device_name' => 'Health Monitor ' . fake()->numberBetween(1, 999),

            'firmware_version' => 'v' . fake()->numberBetween(1, 3) . '.' . fake()->numberBetween(0, 9) . '.' . fake()->numberBetween(0, 9),

            'auth_token' => Str::random(64),

            'status' => fake()->randomElement([
                'active',
                'inactive',
            ]),

            'last_seen_at' => fake()->optional(0.8)->dateTimeBetween(
                '-7 days',
                'now'
            ),
        ];
    }

    public function forDoctor(User $doctor): static
{
    return $this->state(fn (array $attributes) => [
        'doctor_id' => $doctor->id,
    ]);
}
}