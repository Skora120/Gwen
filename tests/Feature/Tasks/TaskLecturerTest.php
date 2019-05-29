<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskLecturerTest extends TestCase
{
    use RefreshDatabase;

    protected $group, $lecturer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->group = factory('App\SubjectGroup')->create();
        $this->lecturer = $this->group->owner();
        $this->be($this->lecturer);
    }


    /** @test */
    public function a_lecturer_can_create_task()
    {
        $task = factory('App\Task')->make(['group_id' => $this->group->id]);

        $this->post($this->group->path(), $task->toArray())->assertStatus(302);

        $this->assertDatabaseHas('tasks', $task->toArray());
    }

    /** @test */
    public function a_lecturer_can_view_created_task()
    {
        $task = factory('App\Task')->create(['group_id' => $this->group->id]);

        $this->get($task->path())->assertSee($task->name);
    }

    /** @test */
    public function a_lecturer_can_see_all_tasks_in_group()
    {
        $task = factory('App\Task', 4)->create(['group_id' => $this->group->id]);

        $this->get($task[0]->group->path() . '/tasks')->assertSee($task[0]->name)->assertSee($task[3]->name);
    }

    /** @test */
    public function a_lecturer_can_update_task()
    {
        $this->withoutExceptionHandling();

        $task = factory('App\Task')->create(['group_id' => $this->group->id]);
        $taskUpdated = factory('App\Task')->make(['group_id' => $this->group->id]);

        $this->patch($task->path(), $taskUpdated->toArray())->assertStatus(302);

        $this->assertDatabaseHas('tasks', $taskUpdated->toArray());
    }

    /** @test */
    public function a_student_may_delete_a_task_without_submissions()
    {
        $task = factory('App\Task')->create(['group_id' => $this->group->id]);

        $this->delete($task->path());

        $this->assertDatabaseMissing('tasks', ['name' => $task->name, 'description' => $task->description]);
    }

    /** @test */
    public function a_student_cannot_delete_a_task_with_submissions()
    {
        $task = factory('App\Task')->create(['group_id' => $this->group->id]);
        factory('App\Submission')->create(['task_id' => $task->id]);

        $this->delete($task->path())->assertStatus(403);
    }

    /** @test */
    public function a_lecturer_can_create_task_to_each_group_at_once()
    {
        $subject = $this->group->subject;
        factory('App\SubjectGroup', 3)->create(['subject_id' => $subject->id]);

        $task = factory('App\Task')->make();

        $groups_id = $subject->subject_groups()->pluck('id');

        $this->post($subject->path() . '/task', array_merge($task->toArray(), ['groups' => $groups_id]))->assertStatus(302);

        $tasks_count = $subject->refresh()->subject_groups()->withCount('tasks')->pluck('subject_groups.tasks_count')->sum();

        $this->assertEquals(4, $tasks_count);
    }

    /** @test */
    public function a_lecturer_cannot_create_task_to_each_group_at_once_if_he_does_not_own_group()
    {

        $subject = $this->group->subject;
        $groups = factory('App\SubjectGroup', 3)->create();

        $task = factory('App\Task')->make();

        $groups_id = $groups->pluck('id');


        $this->post($subject->path() . '/task', array_merge($task->toArray(), ['groups' => $groups_id]))->assertStatus(403);
    }
}
