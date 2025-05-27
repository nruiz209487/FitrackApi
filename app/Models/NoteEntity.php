<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteEntity extends Model
{
    protected $table = 'note_table';

    protected $fillable = [
        'header',
        'text',
        'timestamp',
        'user_id',
    ];

    public $timestamps = false;
}
