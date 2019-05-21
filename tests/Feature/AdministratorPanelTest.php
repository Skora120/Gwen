<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdministratorPanelTest extends TestCase
{
    use RefreshDatabase, withFaker;

    /** @test */
    public function an_admin_may_see_administrator_panel()
    {
        $this->be(factory('App\User')->state('admin')->create());

        $this->get('/admin')->assertStatus(200);
    }

    /** @test */
    public function an_unauthorized_user_cannot_see_administrator_panel()
    {
        $this->be(factory('App\User')->create());

        $this->get('/admin')->assertStatus(302);
    }

    /** @test */
    public function an_admin_may_see_subjects_in_panel()
    {
        $subject = factory('App\Subject')->create();
        $this->be(factory('App\User')->state('admin')->create());

        $this->get('/admin/subjects')->assertSee($subject->name);
    }

    /** @test */
    public function an_admin_may_see_all_users()
    {
        $this->be(factory('App\User')->state('admin')->create());

        $this->get('/admin/users')->assertStatus(200);
    }

    /** @test */
    public function an_admin_may_see_user_profile()
    {
        $this->be(factory('App\User')->state('admin')->create());
        $user = factory('App\User')->create();

        $this->get('/admin/users/' . $user->id)->assertSee($user->last_name);
    }

    /** @test */
    public function an_admin_may_edit_user_profile()
    {
        $this->be(factory('App\User')->state('admin')->create());
        $user = factory('App\User')->create();

        $data = [
            'first_name' => 'John',
            'last_name' => 'Test',
            'email' => 'test@example.com',
            'email_confirmation' => 'test@example.com',
            'student_id' => '1111111111',
            'type' => '2',
        ];

        $this->patch('/admin/users/' . $user->id, $data);

        $this->assertDatabaseHas('users', [
            'first_name' => 'John',
            'last_name' => 'Test',
            'email' => 'test@example.com',
            'student_id' => '1111111111',
            'type' => '2',
        ]);
    }

    /** @test */
    public function an_admin_may_see_all_subjects()
    {
        $this->be(factory('App\User')->state('admin')->create());
        $subjects = factory('App\Subject', 10)->create();

        $this->get('/admin/subjects/')->assertSee($subjects[0]->name)->assertSee($subjects[5]->name);
    }

    /** @test */
    public function an_admin_may_see_all_student_submissions()
    {
        $this->be(factory('App\User')->state('admin')->create());
        $submission = factory('App\Submission')->create();

        $user = $submission->user;

        $this->get('/admin/users/'. $user->id .'/submissions')->assertSee($submission->task->name);
    }


}
