<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'heart_rate',
        'body_temperature',
        'ambient_temperature',
        'battery_level',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'body_temperature' => 'decimal:2',
            'ambient_temperature' => 'decimal:2',
            'recorded_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Device
    |--------------------------------------------------------------------------
    */

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}