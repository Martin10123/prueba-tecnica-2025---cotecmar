<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{

    use SoftDeletes;

    protected $fillable = ['id', 'project_id', 'name'];

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function getProjectIdAttribute()
    {
        return $this->attributes['project_id'];
    }
}