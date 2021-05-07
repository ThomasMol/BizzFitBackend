<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiConnection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fitness_api_id',
        'date_last_retrieved'
    ];
}
