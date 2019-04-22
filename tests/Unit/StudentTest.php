<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_with_specific_type_is_a_student()
    {
        $user = factory('App\User')->create();
        $lecturer = factory('App\User')->create(['type' => 1]);


        $this->assertTrue($user->isStudent());
        $this->assertFalse($lecturer->isStudent());
    }
}
