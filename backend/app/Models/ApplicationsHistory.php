<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationsHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'status_date',
        'application_id',
    ];
}
