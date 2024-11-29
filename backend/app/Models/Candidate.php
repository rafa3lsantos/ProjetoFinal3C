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
        'password',
        'cpf',
        'gender',
        'birthdate',
        'phone',
        'cep',
        'address',
        'state',
        'city',
        'about_candidate',
        'photo',
        'soft_skills',
        'hard_skills',
        'language',
        'level',
        'formation',
        'institution',
        'experience',
        'degree',
        'status',
        'course',
        'start_date_course',
        'end_date_course',
        'certificate_type',
        'certificate_title',
        'certificate_description',
        'certificate_institution',
        'company',
        'position',
        'is_currently_working',
        'start_date_work',
        'end_date_work',
        'description_ativities',
    ];

    protected $casts = [
        'soft_skills' => 'array',
        'hard_skills' => 'array',
        'language' => 'string',
        'start_date_course' => 'date',
        'end_date_course' => 'date',
        'start_date_work' => 'date',
        'end_date_work' => 'date',
        'is_currently_working' => 'boolean',
        'birthdate' => 'date',
    ];
}
