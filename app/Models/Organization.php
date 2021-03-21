<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Organization extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    // Use this if your using UUIDs
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // Add id as fillable when using UUIDs
    protected $fillable = [
        'id',
        'name',
        'industry',
        'size',
        'score',
    ];
}
