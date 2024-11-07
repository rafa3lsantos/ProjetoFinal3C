<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Candidate extends Authenticatable
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

    // Relacionamentos adicionais podem ser adicionados aqui conforme necessário
}
