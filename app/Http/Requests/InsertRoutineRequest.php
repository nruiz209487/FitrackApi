<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutineEntity extends Model
{
    // Use the correct table name as per your database
    protected $table = 'routine_entities';

    protected $fillable = [
        'name',
        'description',
        'imageUri',
        'exerciseIds',
        'user_id',
    ];

    public $timestamps = false;
}
