<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Applications;

class Jobs extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'work_model',
        'job_type',
        'jobs_state',
        'jobs_city',
        'jobs_status',
        'jobs_description',
        'company_id',
    ];

    public function jobs() { 
        return $this->hasMany(Jobs::class);
    }

    public function applications()
    {
        return $this->hasMany(Applications::class);
    }
}
