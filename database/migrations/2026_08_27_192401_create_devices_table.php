<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Doctor
            |--------------------------------------------------------------------------
            |
            | The doctor who registered/owns this ESP32.
            |
            */
            $table->foreignId('doctor_id')
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Patient
            |--------------------------------------------------------------------------
            |
            | The patient currently assigned to this ESP32.
            | Nullable because a device can exist before being assigned.
            |
            */
            $table->foreignId('patient_id')
                ->nullable()
                ->constrained('patients')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | ESP32 Identification
            |--------------------------------------------------------------------------
            */

            $table->string('device_uid')->unique();

            $table->string('mac_address')->unique();


            /*
            |--------------------------------------------------------------------------
            | Device Information
            |--------------------------------------------------------------------------
            */

            $table->string('device_name')->nullable();

            $table->string('device_type')->default('ESP32');

            $table->string('firmware_version')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Authentication
            |--------------------------------------------------------------------------
            |
            | Token used by the ESP32 when communicating with Laravel.
            |
            */

            $table->string('auth_token', 64)->unique();


            /*
            |--------------------------------------------------------------------------
            | Device Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'inactive',
                'blocked'
            ])->default('inactive');


            /*
            |--------------------------------------------------------------------------
            | Communication
            |--------------------------------------------------------------------------
            */

            $table->timestamp('last_seen_at')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Registration
            |--------------------------------------------------------------------------
            */

            $table->timestamp('registered_at')->nullable();


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('status');

            $table->index('doctor_id');

            $table->index('patient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};