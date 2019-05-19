<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function a_user_can_register()
    {
        $this->withoutExceptionHandling();
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'student_id' => 11111111
        ];

        $response = $this->post('/register', $data);

        $this->assertEquals($response->status(), 302);

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'last_name' => $data['last_name'],
        ]);
    }

    /** @test */
    public function a_user_can_see_settings_page()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        $this->get('/settings')->assertSee($user->email);
    }

    /** @test */
    public function a_user_can_change_his_password()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        $user_old_password = $user->password;

        $this->patch('/settings', ['password' => 'test1234', 'password_confirmation' => 'test1234']);

        $this->assertNotEquals($user->refresh()->password, $user_old_password);
    }

    /** @test */
    public function a_user_can_change_his_email()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        $user_old_email = $user->email;

        $this->patch('/settings', ['email' => 'test2323@example.com', 'email_confirmation' => 'test2323@example.com']);

        $this->assertNotEquals($user->refresh()->email, $user_old_email);
    }

    /** @test */
    public function a_user_can_change_his_student_id()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        $user_old_student_id = $user->student_id;

        $this->patch('/settings', ['student_id' => '1111111111']);

        $this->assertNotEquals($user->refresh()->student_id, $user_old_student_id);
    }
}
