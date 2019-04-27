<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function an_unauthorized_user_cannot_create_task()
    {
        $group = factory('App\SubjectGroup')->create();
        $user = factory('App\User')->create();
        $this->be($user);

        $task = factory('App\Task')->make(['group_id' => $group->id]);
        $this->post($group->path(), $task->toArray())->assertStatus(403);
    }

    /** @test */
    public function a_guest_cannot_see_task()
    {
        $task = factory('App\Task')->create();
        $this->get($task->path())->assertStatus(302);
    }

    /** @test */
    public function a_student_can_see_task_in_his_group()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        $group = factory('App\SubjectGroup')->create();

        factory('App\SubjectGroupUser')->create(['group_id' => $group->id, 'user_id' => $user->id]);

        $task = factory('App\Task')->create(['group_id' => $group->id]);

        $this->get($task->path())->assertSee($task->name);
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_task()
    {
        $this->be(factory('App\User')->create());

        $task = factory('App\Task')->create();
        $taskUpdated = factory('App\Task')->make();

        $this->patch($task->path(), $taskUpdated->toArray())->assertStatus(403);
    }
}
