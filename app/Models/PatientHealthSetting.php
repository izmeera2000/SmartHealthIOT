<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientHealthSetting extends Model
{
    protected $fillable = [
        'patient_id',

        'heart_rate_min',
        'heart_rate_max',

        'spo2_min',
        'spo2_max',

        'body_temperature_min',
        'body_temperature_max',

        'ambient_temperature_min',
        'ambient_temperature_max',
    ];

    protected $casts = [
        'heart_rate_min' => 'integer',
        'heart_rate_max' => 'integer',

        'spo2_min' => 'integer',
        'spo2_max' => 'integer',

        'body_temperature_min' => 'decimal:2',
        'body_temperature_max' => 'decimal:2',

        'ambient_temperature_min' => 'decimal:2',
        'ambient_temperature_max' => 'decimal:2',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}