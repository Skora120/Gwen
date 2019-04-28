<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function an_authorized_student_can_upload_task_submission()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();
        $this->be($user);
        $group = factory('App\SubjectGroupUser')->create(['user_id' => $user->id]);
        $task = factory('App\Task')->create(['group_id' => $group->id]);

        $submission = factory('App\Submission')->make();

        $file = UploadedFile::fake()->create('test.pdf','200');

        $this->post($task->path(), array_merge ($submission->toArray(), ['file' => $file]))->assertStatus(302);

        $this->assertDatabaseHas('submissions', ['user_id' => $user->id, 'task_id' => $task->id, 's_comment' => $submission->s_comment]);
    }
}
