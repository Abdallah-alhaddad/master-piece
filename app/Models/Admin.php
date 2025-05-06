<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{

    use HasFactory , SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'phone', 'role'];

    // An admin can create many doctors


    // An admin can create many specializations
    public function specializations()
    {
        return $this->hasMany(Specialization::class, 'created_by');
    }
}
