<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $task, $submission, $file, $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
        $this->be($this->user);
        $group = factory('App\SubjectGroupUser')->create(['user_id' => $this->user->id]);
        $this->task = factory('App\Task')->create(['group_id' => $group->id]);

        $this->submission = factory('App\Submission')->make();

        $this->file = UploadedFile::fake()->create('test.pdf',200);
    }


    /** @test */
    public function a_authorized_student_can_upload_task_submission()
    {
        $this->post($this->task->path(), array_merge ($this->submission->toArray(), ['file' => $this->file]))->assertStatus(302);

        $this->assertDatabaseHas('submissions', ['user_id' => $this->user->id, 'task_id' => $this->task->id, 's_comment' => $this->submission->s_comment]);
    }

    /** @test */
    public function a_authorized_student_cannot_send_more_than_3_submissions()
    {
        $this->post($this->task->path(), array_merge ($this->submission->toArray(), ['file' => $this->file]))->assertStatus(302);
        $this->post($this->task->path(), array_merge ($this->submission->toArray(), ['file' => $this->file]))->assertStatus(302);
        $this->post($this->task->path(), array_merge ($this->submission->toArray(), ['file' => $this->file]))->assertStatus(302);
        $this->post($this->task->path(), array_merge ($this->submission->toArray(), ['file' => $this->file]))->assertStatus(403);
    }

    /** @test */
    public function an_unauthorized_user_cannot_submit_a_task()
    {
        $this->be(factory('App\User')->create());

        $this->post($this->task->path(), array_merge ($this->submission->toArray(), ['file' => $this->file]))->assertStatus(403);
    }

    /** @test */
    public function a_authorized_student_may_see_submission()
    {
        $response = $this->postJson($this->task->path(), array_merge ($this->submission->toArray(), ['file' => $this->file]));

        $this->get($this->task->path() . '/' . $response->json()['id'])->assertSee($this->submission->s_comment);
    }

    /** @test */
    public function a_authorized_student_can_upload_file_with_pdf_extension()
    {
        $file = UploadedFile::fake()->create('test.pdf',200);

        $this->post($this->task->path(), array_merge ($this->submission->toArray(), ['file' => $file]))->assertStatus(302);
        $this->assertDatabaseHas('submissions', ['user_id' => $this->user->id, 'task_id' => $this->task->id, 's_comment' => $this->submission->s_comment]);
    }

    /** @test */
    public function a_authorized_student_can_upload_file_with_zip_extension()
    {
        $file = UploadedFile::fake()->create('test.zip',200);

        $this->post($this->task->path(), array_merge ($this->submission->toArray(), ['file' => $file]))->assertStatus(302);
        $this->assertDatabaseHas('submissions', ['user_id' => $this->user->id, 'task_id' => $this->task->id, 's_comment' => $this->submission->s_comment]);
    }
}
