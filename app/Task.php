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

    public static function swapOrderOfTasks($target_id, $replacement_id)
    {
        $tasks = self::find([$target_id, $replacement_id]);
        if (count($tasks) == 2) {
            $first_task_order = $tasks[0] -> order;
            $tasks[0] -> order = $tasks[1] -> order;
            $tasks[1] -> order = $first_task_order;

            if ($tasks[1]->save() && $tasks[0]->save()) {
                return 1;
            }
        }
    }
}
