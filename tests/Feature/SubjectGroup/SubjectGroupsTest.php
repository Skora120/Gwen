<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectGroupsTest extends TestCase
{
    use RefreshDatabase;


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
    public function an_unauthenticated_cannot_create_subject_group()
    {
        $this->be(factory('App\User')->create());

        $subject = factory('App\Subject')->create();

        $this->post($subject->path(), [])->assertStatus(403);
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

        $this->post(route('subject-join'), ['code' => $group->code])->assertRedirect($group->path());
    }

    /** @test */
    public function a_student_cannot_join_twice_to_subject_group()
    {
        $group = factory('App\SubjectGroup')->create();

        $user = factory('App\User')->create();
        $this->be($user);

        $this->post(route('subject-join'), ['code' => $group->code])->assertRedirect($group->path());
        $this->post(route('subject-join'), ['code' => $group->code])->assertStatus(403);
    }

    /** @test */
    public function a_student_can_visit_his_group()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        $user_in_group = factory('App\SubjectGroupUser')->create(['user_id' => $user->id]);

        $this->get($user_in_group->group->path())->assertSee($user_in_group->group->code);
    }

    /** @test */
    public function a_student_cannot_delete_his_or_any_group()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        $user_in_group = factory('App\SubjectGroupUser')->create(['user_id' => $user->id])->group;

        $group_without_user = factory('App\SubjectGroupUser')->create()->group;

        $this->delete($user_in_group->path())->assertSee(403);
        $this->delete($group_without_user->path())->assertSee(403);
    }
}
