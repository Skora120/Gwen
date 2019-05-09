<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionAdminTest extends TestCase
{
    use RefreshDatabase;
    protected $submission;

    /** @test */
    public function an_admin_can_delete_submissions()
    {
        $this->submission = factory('App\Submission')->create();

        $this->be(factory('App\User')->state('admin')->create());

        $this->delete($this->submission->path());

        $this->assertDatabaseMissing('submissions', ['r_comment' => $this->submission->r_comment]);
    }
}
