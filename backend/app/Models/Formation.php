<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'institution',
        'degree',   
        'status',
        'course',
        'start_date',
        'end_date',
        'candidate_id',
    ];
}
