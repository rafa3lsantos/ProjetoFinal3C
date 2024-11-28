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
        'photo',
        'cep',
        'address',
        'state',
        'city',
    ];


    public function professionalExperiences()
    {
        return $this->hasMany(ProfessionalExperience::class);
    }

    public function formations()
    {
        return $this->hasMany(Formation::class);
    }

}
