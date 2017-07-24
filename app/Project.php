<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{

    protected $table = 'projects';

    protected $fillable = ['name', 'user_id'];

    public function getProjects()
    {
        $projects = Project::OfUser(Auth::user()->id)->get();
        return $projects->toArray();
    }

    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function getProjectlists()
    {
        $result = array();
        $projects = $this->getProjects();
        foreach ($projects as $project) {
            $result[$project['name']] = $this->getTasks($project['id']);
        }
        return array(
            'projectlists' => $result,
            'projects' => $projects
        );
    }

    public function getTasks($project_id)
    {
        $tasks = Task::ofProject($project_id)->orderBy('order', 'ASC')->get();
        return $tasks->toArray();
    }
}
