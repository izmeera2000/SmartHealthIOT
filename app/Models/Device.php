<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'device_uid',
        'mac_address',
        'device_name',
        'device_type',
        'firmware_version',
        'auth_token',
        'status',
        'last_seen_at',
        'registered_at',
    ];

    protected $hidden = [
        'auth_token',
    ];

    protected function casts(): array
    {
        return [
            'last_seen_at' => 'datetime',
            'registered_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Doctor
    |--------------------------------------------------------------------------
    |
    | The doctor who registered/owns this device.
    |
    */

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Patient
    |--------------------------------------------------------------------------
    |
    | The patient currently assigned to this device.
    |
    */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Sensor Readings
    |--------------------------------------------------------------------------
    */

    public function sensorReadings()
    {
        return $this->hasMany(SensorReading::class);
    }
}