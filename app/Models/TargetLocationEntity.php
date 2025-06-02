<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetLocationEntity extends Model
{
    protected $table = 'target_location_table';

    protected $fillable = [
        'id' ,
        'name' ,
        'position' ,
        'radiusMeters' ,
    ];

    public $timestamps = false;
}
