<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_authorized_student_can_upload_task_submission()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        $group = factory('App\SubjectGroupUser')->create(['user_id' => $user->id]);
        $task = factory('App\Task')->create(['group_id' => $group->id]);

        $submission = factory('App\Submission')->make();

        $file = UploadedFile::fake()->create('test.pdf',200);

        $this->post($task->path(), array_merge ($submission->toArray(), ['file' => $file]))->assertStatus(302);

        $this->assertDatabaseHas('submissions', ['user_id' => $user->id, 'task_id' => $task->id, 's_comment' => $submission->s_comment]);
    }

    /** @test */
    public function a_authorized_student_cannot_send_more_than_3_submissions()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        $group = factory('App\SubjectGroupUser')->create(['user_id' => $user->id]);
        $task = factory('App\Task')->create(['group_id' => $group->id]);

        $submission = factory('App\Submission')->make();

        $file = UploadedFile::fake()->create('test.pdf',200);

        $this->post($task->path(), array_merge ($submission->toArray(), ['file' => $file]))->assertStatus(302);
        $this->post($task->path(), array_merge ($submission->toArray(), ['file' => $file]))->assertStatus(302);
        $this->post($task->path(), array_merge ($submission->toArray(), ['file' => $file]))->assertStatus(302);
        $this->post($task->path(), array_merge ($submission->toArray(), ['file' => $file]))->assertStatus(403);
    }

    /** @test */
    public function an_unauthorized_user_cannot_submit_a_task()
    {
        $this->be(factory('App\User')->create());

        $task = factory('App\Task')->create();

        $submission = factory('App\Submission')->make();

        $file = UploadedFile::fake()->create('test.pdf',200);

        $this->post($task->path(), array_merge ($submission->toArray(), ['file' => $file]))->assertStatus(403);
    }

    /** @test */
    public function a_authorized_student_may_see_submission()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        $group = factory('App\SubjectGroupUser')->create(['user_id' => $user->id]);
        $task = factory('App\Task')->create(['group_id' => $group->id]);

        $submission = factory('App\Submission')->make();

        $file = UploadedFile::fake()->create('test.pdf',200);

        $response = $this->postJson($task->path(), array_merge ($submission->toArray(), ['file' => $file]));

        $this->get($task->path() . '/' . $response->json()['id'])->assertSee($submission->s_comment);
    }
}
