<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'work_model',
        'job_type',
        'state_jobs',
        'city_jobs',
        'status_jobs',
        'description_jobs',
        'company_id',
    ];

    public function jobs() { 
        return $this->hasMany(Jobs::class);
    }
}
