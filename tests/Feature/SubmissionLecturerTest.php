<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionLecturerTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function an_lecturer_may_view_submission()
    {
        $submission = factory('App\Submission')->create();

        $lecturer = $submission->task->group->subject->user;
        $this->be($lecturer);

        $this->get($submission->path())->assertSee($submission->s_comment);
    }

    /** @test */
    public function an_unauthorized_user_cannot_see_submission()
    {
        $this->be(factory('App\User')->create());

        $submission = factory('App\Submission')->create();

        $this->get($submission->path())->assertDontSee($submission->s_comment);
    }

    /** @test */
    public function an_lecturer_may_mark_and_leave_response_on_submission()
    {
        $submission = factory('App\Submission')->create();

        $this->be($submission->task->group->subject->user);

        $submissionData = factory('App\Submission')->make()->toArray();

        $this->patch($submission->path(), $submissionData)->assertStatus(302);
        $this->get($submission->path())->assertSee($submissionData['r_comment']);
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_submission()
    {
        $submission = factory('App\Submission')->create();

        $this->be(factory('App\User')->create());

        $submissionData = factory('App\Submission')->make()->toArray();

        $this->patch($submission->path(), $submissionData)->assertStatus(403);
    }
}
