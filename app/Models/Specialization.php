<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Specialization extends Model
{
    protected $fillable = ['name', 'description', 'created_by'];

    // A specialization has many doctors
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    // A specialization is created by an admin
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
