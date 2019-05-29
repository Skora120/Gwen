<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LecturerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_with_specific_type_is_a_lecturer()
    {
        $user = factory('App\User')->create();
        $lecturer = factory('App\User')->create(['type' => 1]);


        $this->assertFalse($user->isLecturer());
        $this->assertTrue($lecturer->isLecturer());
    }
}
