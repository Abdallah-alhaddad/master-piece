<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\DoctorFactory> */

    use HasFactory , SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'doctor_document',
        'phone',
        'specialization_id',
        'bio',
        'experience_years',
        'governorate',
        'address',
        'price_per_appointment',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'working_hours_start',
        'working_hours_end',
        'status'
    ];

    // A doctor belongs to a specialization
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    // A doctor has many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    public function unavailable() {
        return $this->hasMany(DoctorUnavailability::class,'');
    }

    public function subscription() {
        return $this->hasOne(Patient::class);
    }

}
