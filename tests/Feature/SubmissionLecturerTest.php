<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionLecturerTest extends TestCase
{
    use RefreshDatabase;
    protected $submission;

    protected function setUp(): void
    {
        parent::setUp();

        $this->submission = factory('App\Submission')->create();
    }

    /** @test */
    public function an_lecturer_may_view_submission()
    {
        $this->be($this->submission->task->group->subject->user);
        $this->get($this->submission->path())->assertSee($this->submission->s_comment);
    }

    /** @test */
    public function an_unauthorized_user_cannot_see_submission()
    {
        $this->be(factory('App\User')->create());
        $this->get($this->submission->path())->assertDontSee($this->submission->s_comment);
    }

    /** @test */
    public function an_lecturer_may_mark_and_leave_response_on_submission()
    {
        $this->be($this->submission->task->group->subject->user);

        $submissionData = factory('App\Submission')->make()->toArray();

        $this->patch($this->submission->path(), $submissionData)->assertStatus(302);
        $this->get($this->submission->path())->assertSee($submissionData['r_comment']);
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_submission()
    {
        $this->be(factory('App\User')->create());
        $submissionData = factory('App\Submission')->make()->toArray();

        $this->patch($this->submission->path(), $submissionData)->assertStatus(403);
    }
}
