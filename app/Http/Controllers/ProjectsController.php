<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Project::getProjectslist();
        return view('projects.main', ['projectlists' => $data['projectlists'], 'projects' => $data['projects']]);
    }

    public function store(Request $request)
    {
        $project = new Project;
        $project->name = $request->name;
        $project->user_id = Auth::user()->id;

        return $project->save() ? view('projects.new_project', [
            'name' => $project->name,
            'id' => $project->id
        ]) : false;
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        $project->name = $request->name;
        $project->save();
        return array(
            'id' => $project->id,
            'name' => $project->name
        );
    }

    public function destroy($id)
    {
        Project::destroy($id);
    }
}
