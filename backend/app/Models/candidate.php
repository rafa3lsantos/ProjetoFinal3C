<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class candidate extends Model
{
    use HasFactory;

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
