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

    }

    public function destroy($id)
    {
        Task::destroy($id);
    }
}
