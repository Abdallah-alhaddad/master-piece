<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionFactory> */
    use HasFactory;
    protected $fillable = ['doctor_id', 'start_date', 'end_date', 'status'];


    public function doctor()
{
    return $this->belongsTo(Doctor::class, 'doctor_id');
}

}

