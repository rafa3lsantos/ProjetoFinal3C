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
        'recruiter_name',
        'recruiter_cpf',
        'recruiter_gender',
        'recruiter_phone',
        'recruiter_birthdate',
        'email',
        'password',
        'recruiter_photo',
        'company_id',
    ];

    public function candidate() { 
        return $this->hasMany(Candidate::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

