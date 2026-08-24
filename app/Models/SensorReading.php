<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    protected $fillable = [
        'device_id',
        'heart_rate',
        'body_temperature',
        'ambient_temperature',
        'battery_level',
        'recorded_at',
    ];

    protected $casts = [
        'heart_rate' => 'integer',
        'body_temperature' => 'float',
        'ambient_temperature' => 'float',
        'battery_level' => 'integer',
        'recorded_at' => 'datetime',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
