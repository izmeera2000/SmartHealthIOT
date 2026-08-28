<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'ic_number',
        'date_of_birth',
        'gender',
        'phone',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'blood_type',
        'height',
        'weight',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'height' => 'decimal:2',
            'weight' => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | User Account
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Medical Records
    |--------------------------------------------------------------------------
    */

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Medications
    |--------------------------------------------------------------------------
    */

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Allergies
    |--------------------------------------------------------------------------
    */

    public function allergies()
    {
        return $this->hasMany(Allergy::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Devices
    |--------------------------------------------------------------------------
    */

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}