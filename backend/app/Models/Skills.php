<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    use HasFactory;

    protected $fillable = [
        'soft_skills', 
        'hard_skills', 
        'candidate_id',
    ];


    protected $casts = [
        'soft_skills' => 'array',  
        'hard_skills' => 'array', 
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
