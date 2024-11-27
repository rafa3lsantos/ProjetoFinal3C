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
        'jobs_state',
        'jobs_city',
        'jobs_status',
        'jobs_description',
        'recruiter_id',
        'company_id',
    ];

    public function applications()
    {
        return $this->hasMany(Applications::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
