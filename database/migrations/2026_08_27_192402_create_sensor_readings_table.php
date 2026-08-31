<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensor_readings', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | ESP32 Device
            |--------------------------------------------------------------------------
            |
            | Each reading belongs to the device that produced it.
            |
            */
            $table->foreignId('device_id')
                ->constrained('devices')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Health Measurements
            |--------------------------------------------------------------------------
            */

            // Heart rate in BPM
            $table->unsignedInteger('heart_rate')
                ->nullable();

            $table->unsignedInteger('spo2')
                ->nullable();

            // Body temperature in °C
            $table->decimal('body_temperature', 5, 2)
                ->nullable();

            // Temperature around the ESP32/sensor in °C
            $table->decimal('ambient_temperature', 5, 2)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | ESP32 Battery
            |--------------------------------------------------------------------------
            |
            | Value between 0 and 100.
            |
            */

            $table->unsignedTinyInteger('battery_level')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Reading Time
            |--------------------------------------------------------------------------
            |
            | Time when the ESP32 actually took the measurement.
            |
            */

            $table->timestamp('recorded_at');


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            |
            | Useful for retrieving a device's readings chronologically.
            |
            */

            $table->index([
                'device_id',
                'recorded_at'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_readings');
    }
};