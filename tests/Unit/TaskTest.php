<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\User;
use App\Project;
use App\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Session::start();
        $this->prepareForTests();
        DB::beginTransaction();
        $this->user = factory(User::class)->create();
        $this->be($this->user);
    }

    public function testTaskCreating()
    {
        $request = $this->json(
            'POST',
            '/projects',
            ['name' => 'test']
        );
        $request->assertSuccessful();

        $last_project = Project::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first()->toArray();
        $this->assertNotNull($last_project);

        $request = $this->json(
            'POST',
            '/tasks',
            [
                'content' => 'test',
                'project_id' => intval($last_project['id'])
            ]
        );
        $request->assertSuccessful();
    }

    public function testTaskUpdating()
    {
        $request = $this->json(
            'POST',
            '/projects',
            ['name' => 'test']
        );
        $request->assertSuccessful();

        $last_project = Project::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first()->toArray();
        $this->assertNotNull($last_project);

        $create_task_request = $this->json(
            'POST',
            '/tasks',
            [
                'content' => 'test',
                'project_id' => intval($last_project['id'])
            ]
        );
        $create_task_request->assertSuccessful();

        $last_task = Task::where('project_id', $last_project['id'])->first()->toArray();
        $this->assertNotNull($last_task);

        $update_task_request = $this->json(
            'PATCH',
            '/tasks/' . $last_task['id'],
            [
                'content' => 'updated_test'
            ]
        );
        $update_task_request->assertSuccessful();
    }

    public function testTaskRemoving()
    {
        $request = $this->json(
            'POST',
            '/projects',
            ['name' => 'test']
        );
        $request->assertSuccessful();

        $last_project = Project::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first()->toArray();
        $this->assertNotNull($last_project);

        $create_task_request = $this->json(
            'POST',
            '/tasks',
            [
                'content' => 'test',
                'project_id' => intval($last_project['id'])
            ]
        );
        $create_task_request->assertSuccessful();

        $last_task = Task::where('project_id', $last_project['id'])->first()->toArray();
        $this->assertNotNull($last_task);

        $update_task_request = $this->json(
            'DELETE',
            '/tasks/' . $last_task['id']
        );
        $update_task_request->assertSuccessful();
    }

    public function testChangingIsDoneStatus()
    {
        $request = $this->json(
            'POST',
            '/projects',
            ['name' => 'test']
        );
        $request->assertSuccessful();

        $last_project = Project::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first()->toArray();
        $this->assertNotNull($last_project);

        $create_task_request = $this->json(
            'POST',
            '/tasks',
            [
                'content' => 'test',
                'project_id' => intval($last_project['id'])
            ]
        );
        $create_task_request->assertSuccessful();

        $last_task = Task::where('project_id', $last_project['id'])->first()->toArray();
        $this->assertNotNull($last_task);

        $change_done_status_request = $this->json(
            'POST',
            '/tasks/done/' . $last_task['id']
        );
        $change_done_status_request->assertSuccessful();
    }

    public function testSettingDeadline()
    {
        $request = $this->json(
            'POST',
            '/projects',
            ['name' => 'test']
        );
        $request->assertSuccessful();

        $last_project = Project::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first()->toArray();
        $this->assertNotNull($last_project);

        $create_task_request = $this->json(
            'POST',
            '/tasks',
            [
                'content' => 'test',
                'project_id' => intval($last_project['id'])
            ]
        );
        $create_task_request->assertSuccessful();

        $last_task = Task::where('project_id', $last_project['id'])->first()->toArray();
        $this->assertNotNull($last_task);

        $create_task_request = $this->json(
            'POST',
            '/tasks/deadline',
            [
                'deadline' => '2019-08-01',
                'id' => intval($last_task['id'])
            ]
        );
        $create_task_request->assertSuccessful();
    }

    public function testChangingOrderBetweenTwoTasks()
    {
        $request = $this->json(
            'POST',
            '/projects',
            ['name' => 'test']
        );
        $request->assertSuccessful();

        $last_project = Project::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first()->toArray();
        $this->assertNotNull($last_project);

        $create_task_request = $this->json(
            'POST',
            '/tasks',
            [
                'content' => 'test',
                'project_id' => intval($last_project['id'])
            ]
        );
        $create_task_request->assertSuccessful();

        $create__second_task_request = $this->json(
            'POST',
            '/tasks',
            [
                'content' => 'another_test',
                'project_id' => intval($last_project['id'])
            ]
        );
        $create__second_task_request->assertSuccessful();

        $last_tasks = Task::where('project_id', $last_project['id'])->take(2)->get()->toArray();
        $this->assertNotNull($last_tasks);

        $change_orders_request = $this->json(
            'POST',
            '/tasks/order',
            [
                'target_id' => intval($last_tasks[0]['id']),
                'replacement_id' => intval($last_tasks[1]['id'])
            ]
        );
        $create__second_task_request->assertSuccessful();
    }

    public function tearDown()
    {
        DB::rollback();
        DB::commit();
    }
}
