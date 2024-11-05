<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class candidate extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'cpf',
        'email',
        'password',
        'phone',
        'gender',
        'cep',
        'address',
        'state',
        'city',
        'language',
        'curriculum',
    ];

    public function candidate() { 
        return $this->hasMany(Candidate::class);
    }
}
