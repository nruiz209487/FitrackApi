<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutineEntity extends Model
{
    protected $table = 'routine_table';

    protected $fillable = [
        'name',
        'description',
        'imageUri',
        'exerciseIds',
        'userId',
    ];

    public $timestamps = false;
}
