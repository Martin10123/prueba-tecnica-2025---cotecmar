<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use SoftDeletes;

    protected $fillable = ['block_id', 'name', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function pieces()
    {
        return $this->hasMany(Piece::class);
    }

    public function getBlockIdAttribute()
    {
        return $this->attributes['block_id'];
    }
}