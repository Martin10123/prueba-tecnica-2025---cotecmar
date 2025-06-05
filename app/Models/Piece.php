<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Piece extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'theoretical_weight',
        'real_weight',
        'status',
        'block_id',
        'registration_date',
        'registered_by',
    ];

    protected $casts = [
        'theoretical_weight' => 'decimal:2',
        'real_weight' => 'decimal:2',
        'registration_date' => 'datetime',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    // Relación con el usuario que registró la pieza
    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    // Para acceder al ID específico de la pieza
    public function getPieceIdAttribute()
    {
        return $this->attributes['piece_id'];
    }
}