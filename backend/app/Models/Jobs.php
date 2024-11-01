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
        'location',
        'state',
        'city',
        'status',
        'company_id',
    ];

    public function jobs() { 
        return $this->hasMany(Jobs::class);
    }
}
