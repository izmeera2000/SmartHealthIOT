<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_health_configs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Heart Rate
            $table->unsignedSmallInteger('hr_low')->default(50);
            $table->unsignedSmallInteger('hr_high')->default(120);

            // SpO2
            $table->unsignedTinyInteger('spo2_low')->default(90);
            $table->unsignedTinyInteger('spo2_high')->default(100);

            // Temperature (Celsius)
            $table->decimal('temp_low', 4, 1)->default(35.0);
            $table->decimal('temp_high', 4, 1)->default(38.0);

            $table->timestamps();

            // prevent duplicate config per user
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_health_configs');
    }
};