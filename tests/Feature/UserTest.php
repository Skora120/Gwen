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
//        $this->withoutExceptionHandling();
        $password = $this->faker->password;
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirmation' => $password,
            'student_id' => $this->faker->creditCardNumber
        ];

        // Post
        $response = $this->post('/register', $data);

        $this->assertEquals($response->status(), 302);

        // Assert that user exists
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
        ]);
    }
}
