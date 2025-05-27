<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseEntity extends Model
{
    protected $table = 'exercise_table';

    protected $fillable = [
        'name',
        'description',
        'image_uri',
    ];

    public $timestamps = true; 
}
