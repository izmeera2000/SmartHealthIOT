<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'uid',
        'user_id',
        'pairing_code',
        'paired_at'
    ];

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }
}