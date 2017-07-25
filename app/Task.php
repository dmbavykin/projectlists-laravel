<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $table = 'tasks';

    protected $fillable = ['content', 'order', 'is_done'];

    public function scopeOfProject($query, $project_id)
    {
        return $query->where('project_id', $project_id);
    }

}
