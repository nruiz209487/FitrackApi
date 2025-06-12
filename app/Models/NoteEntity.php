<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo para la entidad Note
 */
class NoteEntity extends Model
{
    protected $table = 'note_table';

    protected $fillable = [
        'header',
        'text',
        'timestamp',
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
