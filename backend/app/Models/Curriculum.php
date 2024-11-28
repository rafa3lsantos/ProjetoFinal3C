<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Curriculum extends Model
{
use HasApiTokens;

protected $table = 'curriculum';

protected $fillable = [
    
];

public function candidate()
{
return $this->belongsTo(Candidate::class);
}
}
