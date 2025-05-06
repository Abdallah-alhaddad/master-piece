<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SymptomSpecialization extends Model
{
    protected $table = 'symptom_specialization';
    
    protected $fillable = [
        'symptom',
        'specialization',
        'weight'
    ];
} 