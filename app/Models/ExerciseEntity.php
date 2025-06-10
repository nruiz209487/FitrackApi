<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExerciseEntity extends Model
{
    protected $table = 'exercise_table';

    protected $fillable = [
        'name',
        'description',
        'imageUri',
    ];

    public $timestamps = true;

    /**
     * Relación con el modelo User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
