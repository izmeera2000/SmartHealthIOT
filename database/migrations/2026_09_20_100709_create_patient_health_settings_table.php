<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_health_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->unique()
                ->constrained('patients')
                ->cascadeOnDelete();

            // Heart Rate / BPM
            $table->unsignedSmallInteger('heart_rate_min')
                ->nullable();

            $table->unsignedSmallInteger('heart_rate_max')
                ->nullable();

            // SpO2 percentage
            $table->unsignedTinyInteger('spo2_min')
                ->nullable();

            $table->unsignedTinyInteger('spo2_max')
                ->nullable();

            // Body temperature °C
            $table->decimal('body_temperature_min', 5, 2)
                ->nullable();

            $table->decimal('body_temperature_max', 5, 2)
                ->nullable();

            // Ambient temperature °C
            $table->decimal('ambient_temperature_min', 5, 2)
                ->nullable();

            $table->decimal('ambient_temperature_max', 5, 2)
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_health_settings');
    }
};