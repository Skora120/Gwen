<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function submission_file_is_deleted()
    {
        $submission = factory('App\Submission')->create();

        $submission->delete();

        Storage::disk('local')->assertMissing($submission->file);
    }

    /** @test */
    public function deleting_subject_results_in_cascade_delete_submission()
    {
        $submission = factory('App\Submission')->create();
        $subject = $submission->task->group->subject;

        $subject->delete();

        $this->assertDatabaseMissing('submissions', ['id' => $submission->id]);
    }
}
