<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'doctor_id',
        'device_uid',
        'mac_address',
        'device_name',
        'firmware_version',
        'auth_token',
        'status',
        'last_seen_at',
    ];

    protected $hidden = [
        'auth_token',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function readings()
    {
        return $this->hasMany(SensorReading::class);
    }
}
