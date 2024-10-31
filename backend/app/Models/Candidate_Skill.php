<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate_Skill extends Model
{
    use HasFactory;

    public function skills(){
        return $this->belongsToMany(Skill::class);
    }

}


