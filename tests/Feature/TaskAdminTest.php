<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskAdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_may_delete_task_with_submission()
    {
        $this->be(factory('App\User')->state('admin')->create());

        $task = factory('App\Task')->create();
        factory('App\Submission')->create(['task_id' => $task->id]);

        $this->delete($task->path());

        $this->assertDatabaseMissing('tasks', ['name' => $task->name, 'description' => $task->descirption]);
    }
}
