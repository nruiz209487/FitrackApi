<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo para la entidad Routine
 */
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
    
    /**
     * Relación con el modelo User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }
}

