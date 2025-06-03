<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseLogEntity extends Model
{
    protected $table = 'exercise_log_table';

    protected $fillable = [
        'exerciseId',
        'date',
        'weight',
        'reps',
        'userId',
    ];

    public $timestamps = false;
}
