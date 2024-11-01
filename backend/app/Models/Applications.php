<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'application_date',
        'candidate_id',
        'job_id',
    ];

    public function applications() { 
        return $this->hasMany(Applications::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function job()
    {
        return $this->belongsTo(Jobs::class);
    }
}
