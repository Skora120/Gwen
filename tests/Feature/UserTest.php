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
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'student_id' => 11111111
        ];

        // Post
        $response = $this->post('/register', $data);

        $this->assertEquals($response->status(), 302);

        // Assert that user exists
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'name' => $data['name'],
        ]);
    }
}
