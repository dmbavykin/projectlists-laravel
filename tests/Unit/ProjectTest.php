<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Project;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTest extends TestCase
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

    public function testProjectCreating()
    {
        $request = $this->json(
            'POST',
            '/projects',
            ['name' => 'test']
        );
        $request->assertSuccessful();
    }

    public function testProjectUpdating()
    {
        $request = $this->json(
            'POST',
            '/projects',
            ['name' => 'test']
        );
        $request->assertSuccessful();

        $last_project = Project::orderBy('id', 'DESC')->first()->toArray();
        $this->assertNotNull($last_project);

        $update_request = $this->json(
            'PATCH',
            '/projects/' . $last_project['id'],
            ['name' => 'updated_test']
        );
        $update_request->assertSuccessful();
    }

    public function testProjectRemoving()
    {
        $request = $this->json(
            'POST',
            '/projects',
            ['name' => 'test']
        );
        $request->assertSuccessful();

        $last_project = Project::orderBy('id', 'DESC')->first()->toArray();
        $this->assertNotNull($last_project);

        $update_request = $this->json(
            'DELETE',
            '/projects/' . $last_project['id']
        );
        $update_request->assertSuccessful();
    }

    public function tearDown()
    {
        DB::rollback();
        DB::commit();
    }
}
