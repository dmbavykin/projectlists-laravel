<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->content = $request->content;
        $task->save();
        return array(
            'id' => $task->id,
            'content' => $task->content
        );
    }

    public function destroy($id)
    {
        Task::destroy($id);
    }
}
