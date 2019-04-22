<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectGroupsTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function a_lecturer_can_see_subject_group()
    {
        $user = factory('App\User')->state('lecturer')->create();
        $this->be($user);
        $subject = factory('App\Subject')->create(['user_id' => $user->id]);

        $subject_groups = factory('App\SubjectGroup')->create(['subject_id' => $subject->id]);

        $this->get($subject->path() . '/' . $subject_groups->id)->assertSee($subject_groups->code);
    }

    /** @test */
    public function an_unauthenticated_cannot_see_subject_group()
    {
        $subject_groups = factory('App\SubjectGroup')->create();

        $this->get($subject_groups->subject->path() . '/' . $subject_groups->id)->assertRedirect('/login');
    }

    /** @test */
    public function an_unauthorized_user_cannot_see_subject_group()
    {
        $subject_groups = factory('App\SubjectGroup')->create();
        $this->be(factory('App\User')->create());
        $this->get($subject_groups->subject->path() . '/' . $subject_groups->id)->assertStatus(403);
    }

    /** @test */
    public function a_lecturer_can_create_subject_group()
    {
        $user = factory('App\User')->state('lecturer')->create();
        $this->be($user);

        $subject = factory('App\Subject')->create(['user_id' => $user->id]);

        $this->post($subject->path(), []);

        $this->assertCount(1, $subject->subject_groups()->get());
    }

    /** @test */
    public function an_unauthenticated_cannot_create_subject_group()
    {
        $this->be(factory('App\User')->create());

        $subject = factory('App\Subject')->create();

        $this->post($subject->path(), [])->assertStatus(403);
    }

    /** @test */
    public function a_lecturer_can_edit_own_subject_group()
    {
        $this->withoutExceptionHandling();
        $user = factory('App\User')->state('lecturer')->create();
        $this->be($user);

        $subject = factory('App\Subject')->create(['user_id' => $user->id]);
        $group = factory('App\SubjectGroup')->create(['subject_id' => $subject->id]);

        $data = ['name' => 'Some Name'];

        $this->patch($group->path(), $data);

        $this->assertEquals($data['name'], $group->fresh()->name);
    }

    /** @test */
    public function an_unauthorized_user_cannot_edit__subject_group()
    {
        $this->be(factory('App\User')->create());
        $group = factory('App\SubjectGroup')->create();

        $this->patch($group->path(), [])->assertStatus(403);

    }


    /** @test */
    public function a_student_can_join_to_subject_group()
    {
        $group = factory('App\SubjectGroup')->create();
        $user = factory('App\User')->create();
        $this->be($user);

        $this->post('/subjects/join_group', ['code' => $group->code])->assertRedirect($group->path());
    }

    /** @test */
    public function a_student_cannot_join_twice_to_subject_group()
    {
        $group = factory('App\SubjectGroup')->create();

        $user = factory('App\User')->create();
        $this->be($user);

        $this->post('/subjects/join_group', ['code' => $group->code])->assertRedirect($group->path());
        $this->post('/subjects/join_group', ['code' => $group->code])->assertStatus(403);
    }
}
