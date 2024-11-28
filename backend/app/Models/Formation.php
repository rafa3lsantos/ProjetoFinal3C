<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'candidate_id',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
