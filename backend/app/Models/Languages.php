<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    use HasFactory;

    protected $fillable = [
        'language',
        'level',
        'candidate_id',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
