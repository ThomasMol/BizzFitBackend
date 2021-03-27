<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentalState extends Model
{
    use HasFactory;

    // Use this if your using UUIDs
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'points',
        'state',
        'date_time'
    ];
}
