<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHealthConfig extends Model
{
    protected $fillable = [
        'user_id',
        'hr_low', 'hr_high',
        'spo2_low', 'spo2_high',
        'temp_low', 'temp_high',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}