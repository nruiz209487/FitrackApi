<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    
    /**
     * Relación con el modelo User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
