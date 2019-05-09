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
        $this->withoutExceptionHandling();

        $submission = factory('App\Submission')->create();

        $submission->delete();

        Storage::disk('local')->assertMissing($submission->file);
    }
}
