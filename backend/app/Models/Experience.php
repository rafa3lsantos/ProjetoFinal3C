<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'job_id',
        'start_date',
        'end_date',
        'description',
        'candidate_id',
    ];
}
