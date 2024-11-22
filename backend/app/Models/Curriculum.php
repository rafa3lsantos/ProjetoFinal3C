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
'experience',
'formation',
'institution',
'degree',
'status',
'course',
'start_date',
'end_date',
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

public function candidate()
{
return $this->belongsTo(Candidate::class);
}
}
