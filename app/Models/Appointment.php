<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'doctor_id', 'patient_id', 'appointment_date', 'appointment_time', 'status', 'payment_status'
    ];

    // An appointment belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // An appointment belongs to a patient (nullable)
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
