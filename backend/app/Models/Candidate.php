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
        'email',
        'new_email',
        'password',
        'new_password',
        'about_candidate',
        'cpf',
        'birthdate',
        'gender',
        'phone',
        'curriculum',
        'photo'
    ];

    public function curriculum()
    {
        return $this->hasOne(Curriculum::class);
    }

}
