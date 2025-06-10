<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TargetLocationEntity extends Model
{
    protected $table = 'target_location_table';

    protected $fillable = [
        'name',
        'position',
        'radiusMeters',
        'userId',
    ];

    public $timestamps = true;

    protected $casts = [
        'radiusMeters' => 'float',
        'userId' => 'integer',
    ];

    /**
     * Relación con el modelo User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }

    /**
     * Accessor para obtener position como array
     */
    public function getPositionArrayAttribute()
    {
        if (!$this->position) {
            return null;
        }

        [$lat, $lng] = explode(',', $this->position);
        return [
            'latitude' => (float) $lat,
            'longitude' => (float) $lng,
        ];
    }
}