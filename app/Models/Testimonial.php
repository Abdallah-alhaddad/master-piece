<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['content', 'user_id', 'patient_id'];

    // A testimonial belongs to a user (nullable)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A testimonial belongs to a patient (nullable)
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
