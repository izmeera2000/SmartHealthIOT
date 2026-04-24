<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    protected $fillable = [
        'device_id',
        'heart_rate',
        'spo2',
        'lat',
        'lng'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}