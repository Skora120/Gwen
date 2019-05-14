<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function deleting_subject_results_in_cascade_delete_groups_and_tasks()
    {
        $task = factory('App\Task')->create();
        $group = $task->group;
        $subject = $task->group->subject;

        $subject->delete();

        $this->assertDatabaseMissing('subjects', $subject->toArray());
        $this->assertDatabaseMissing('subject_groups', ['id' => $group->id]);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
