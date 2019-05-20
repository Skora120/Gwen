<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectGroupLecturerTest extends TestCase
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
    public function a_lecturer_can_create_subject_group()
    {
        $user = factory('App\User')->state('lecturer')->create();
        $this->be($user);

        $subject = factory('App\Subject')->create(['user_id' => $user->id]);

        $this->post($subject->path(), []);

        $this->assertCount(1, $subject->subject_groups()->get());
    }

    /** @test */
    public function a_lecturer_can_edit_own_subject_group()
    {
        $user = factory('App\User')->state('lecturer')->create();
        $this->be($user);

        $group = factory('App\SubjectGroup')->create(['subject_id' => factory('App\Subject')->create(['user_id' => $user->id])->id]);

        $data = ['name' => 'Some Name'];

        $this->patch($group->path(), $data);
        $this->assertEquals($data['name'], $group->fresh()->name);
    }

    /** @test */
    public function a_lecturer_cannot_join__to_own_subject_group()
    {
        $user = factory('App\User')->create();
        $this->be($user);

        $subject = factory('App\Subject')->create(['user_id' => $user->id]);
        $group = factory('App\SubjectGroup')->create(['subject_id' => $subject->id]);

        $this->post(route('subject-join'), ['code' => $group->code])->assertStatus(403);
    }

    /** @test */
    public function a_lecturer_can_delete_group_without_any_students()
    {
        $group = factory('App\SubjectGroup')->create();
        $this->be($group->owner());

        $this->delete($group->path());

        $this->assertDatabaseMissing('subject_groups', ['name' => $group->name, 'code' => $group->code]);
    }

    /** @test */
    public function a_lecturer_cannot_delete_group_with_students()
    {
        $group = factory('App\SubjectGroup')->create();
        factory('App\SubjectGroupUser')->create(['group_id' => $group->id]);
        $this->be($group->owner());

        $this->delete($group->path());

        $this->assertDatabaseHas('subject_groups', ['name' => $group->name, 'code' => $group->code]);
    }
}
