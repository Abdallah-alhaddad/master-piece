<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorUnavailability extends Model
{

    use HasFactory;
    protected $fillable = ['doctor_id', 'date', 'start_time'];
    protected $casts = [
        'date' => 'date',
    ];
    /** @use HasFactory<\Database\Factories\DoctorUnavailabilityFactory> */

    function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
