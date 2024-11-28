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
        'company',
        'position',
        'is_currently_working',
        'start_date_work',
        'end_date_work',
        'description_ativities',
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
        'soft_skills',
        'hard_skills',
        'language',
        'language_level',
        'curriculum_attachment',
    ];

    public function curriculum()
    {
        return $this->hasOne(Curriculum::class);
    }

}
