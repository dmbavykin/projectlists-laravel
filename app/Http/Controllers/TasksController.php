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
        $task = new Task;
        $task->content = $request->content;
        $task->project_id = $request->project_id;
        $task->order = $request->order;
        $task->is_done = 0;
        $task->save();
        return view('projects.new_task', ['task' => $task]);
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

    public function changeDoneStatus($id)
    {
        $task = Task::find($id);
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
        $task->deadline = $request->deadline;
        $task->save();
    }
}
