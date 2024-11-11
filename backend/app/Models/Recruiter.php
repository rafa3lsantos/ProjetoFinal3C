<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Recruiter extends Authenticatable
{
    use HasFactory, HasApiTokens; 

    protected $fillable = [
        'name_recruiter',
        'cpf_recruiter',
        'birthdate_recruiter',
        'email_recruiter',
        'password_recruiter',
        'photo_recruiter',
        'company_id',
    ];

    public function candidate() { 
        return $this->hasMany(Candidate::class);
    }
}

