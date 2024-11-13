<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Candidate extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name_candidate',
        'cpf',
        'about_candidate',
        'birthdate',
        'gender',
        'phone',
        'email',
        'password',
        'new_password',
        'photo'
    ];

}
