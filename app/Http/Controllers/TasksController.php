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

    public function store(Request $request)
    {
        if (!$request->content) return false;
        $task = new Task;
        $task->content = $request->content;
        $task->project_id = $request->project_id;
        $task->order = Task::getLastOrderOfProject($request->project_id) + 1;
        $task->save();
        return view('projects.new_task', ['task' => $task]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) return false;
        $task->content = $request->content;

        return $task->save() ? [
            'id' => $task->id,
            'content' => $task->content
        ] : false;
    }

    public function destroy($id)
    {
        return Task::destroy($id);
    }

    public function changeDoneStatus($id)
    {
        $task = Task::find($id);
        if (!$task) return false;
        $task->is_done = !$task->is_done;
        $task->save();
    }

    public function changeOrder(Request $request)
    {
        return Task::swapOrderOfTasks(
            $request->target_id,
            $request->replacement_id
        );
    }

    public function changeDeadline(Request $request)
    {
        $task = Task::find($request->id);
        if (!$task) return false;
        $task->deadline = $request->deadline;
        $task->save();
    }
}
