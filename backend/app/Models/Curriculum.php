<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculum';

    protected $fillable = [
        'candidate_id',
        'name',
        'email',
        'phone',
        'cep',
        'address',
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

    // Relacionamento com o modelo Candidate
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
