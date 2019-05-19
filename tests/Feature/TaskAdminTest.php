<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskAdminTest extends TestCase
{
    use RefreshDatabase, withFaker;

    /** @test */
    public function an_admin_may_delete_task_with_submission()
    {
        $this->be(factory('App\User')->state('admin')->create());

        $task = factory('App\Task')->create();
        factory('App\Submission')->create(['task_id' => $task->id]);

        $this->delete($task->path());

        $this->assertDatabaseMissing('tasks', ['name' => $task->name, 'description' => $task->descirption]);
    }

    /** @test */
    public function first_create_account_is_an_admin_type()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'student_id' => 11111111
        ];

        $this->post('/register', $data);
        $this->assertTrue(User::first()->isAdmin());
    }

    /** @test */
    public function accounts_created_after_first_account_are_normal_students_accounts()
    {
        factory('App\User')->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'student_id' => 11111111
        ];
        $this->post('/register', $data);

        $this->assertTrue(User::where('email', $data['email'])->first()->isStudent());
    }
}
