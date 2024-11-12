<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class Company extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'company_name',
        'company_cnpj',
        'company_phone',
        'email',
        'password',
        'company_photo',
        'company_sector',
        'about_company',
    ];

    public function companies() { 
        return $this->hasMany(Company::class);
    }
}
