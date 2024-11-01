<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class Candidate_Skill extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'skill_id',
    ];
}


