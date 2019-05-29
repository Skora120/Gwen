<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function subject_has_path()
    {
        $group = factory('App\SubjectGroup')->create();

        $this->assertEquals($group->path(), $group->subject->path() . '/' . $group->id);
    }
}
