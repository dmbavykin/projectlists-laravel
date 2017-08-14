<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{

    protected $table = 'projects';

    protected $fillable = ['name', 'user_id'];

    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    protected static function getProjects()
    {
        $projects = self::OfUser(Auth::user()->id)->get();
        return $projects->toArray();
    }

    public static function getProjectslist()
    {
        $result = [];
        $projects = self::getProjects();
        foreach ($projects as $project) {
            $result[$project['name']] = self::getTasks($project['id']);
        }
        return [
            'projectlists' => $result,
            'projects' => $projects
        ];
    }

    protected static function getTasks($project_id)
    {
        $tasks = Task::ofProject($project_id)->orderBy('order')->get();
        return $tasks->toArray();
    }
}
