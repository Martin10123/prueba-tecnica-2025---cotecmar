<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    protected $primaryKey = 'id';

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
        return $this->belongsTo(Block::class, 'block_id', 'id');
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by', 'id');
    }
}
