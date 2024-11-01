<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function candidates()
    {
        return $this->belongsToMany->using(Candidate::class, 'candidate_skills', 'skill_id', 'candidate_id');
    }
}


