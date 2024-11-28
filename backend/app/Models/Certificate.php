<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'titulo',
        'descricao',
        'anexar_conquista',
        'candidate_id',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
