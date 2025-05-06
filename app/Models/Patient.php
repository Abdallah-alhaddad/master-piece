<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'phone', 'user_id'];

    // A patient belongs to a user (if registered)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A patient can have many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
}
