<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruiter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'birthdate',
        'email',
        'password',
        'company_id',
    ];

    
}
