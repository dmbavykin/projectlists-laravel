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

    public function index(Project $project)
    {
        $data = $project->getProjectlists();
        return view('projects.main', ['projectlists' => $data['projectlists'], 'projects' => $data['projects']]);
    }

    public function store(Request $request)
    {
        $project = new Project;
        $project->name = $request->name;
        $project->user_id = Auth::user()->id;
        $project->save();
        return view('projects.new_project', [
            'name' => $project->name,
            'id' => $project->id
        ]);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        Project::destroy($id);
    }
}
