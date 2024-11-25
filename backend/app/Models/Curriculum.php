<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Curriculum extends Model
{
use HasApiTokens;

protected $table = 'curriculum';

protected $fillable = [
    'candidate_id',
    'name_candidate',
    'email',
    'phone',
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
    'candidate_id',
];

public function candidate()
{
return $this->belongsTo(Candidate::class);
}
}
