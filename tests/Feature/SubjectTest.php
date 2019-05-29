<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function a_lecturer_can_create_subject()
    {
        $lecturer = factory('App\User')->state('lecturer')->create();
        $this->be($lecturer);

        $subject = factory('App\Subject')->make(['user_id' => auth()->id()]);

        $this->post('/subjects',$subject->toArray());

        $this->assertDatabaseHas('subjects', ['name' => $subject->name, 'description' => $subject->description]);
    }

    /** @test */
    public function user_has_to_be_signed_in_to_create_subject()
    {
        $this->post('/subjects',[])->assertRedirect('/login');
    }

    /** @test */
    public function an_unauthorized_user_cannot_create_subject()
    {
        $lecturer = factory('App\User')->create();
        $this->be($lecturer);

        $subject = factory('App\Subject')->make(['user_id' => auth()->id()]);

        $response = $this->post('/subjects',$subject->toArray());

        $this->assertEquals(403, $response->status());

        $this->assertDatabaseMissing('subjects', $subject->toArray());
    }

    /** @test */
    public function a_lecturer_can_see_his_subjects()
    {
        $lecturer = factory('App\User')->state('lecturer')->create();
        $this->be($lecturer);

        $subject = factory('App\Subject')->create(['user_id' => $lecturer->id]);


        $this->get('/subjects')->assertSee($subject->name);
    }

    /** @test */
    public function a_authenticated_user_can_see_subject()
    {
        $lecturer = factory('App\User')->state('lecturer')->create();
        $this->be($lecturer);

        $subject = factory('App\Subject')->create(['user_id' => auth()->id()]);
        $this->get($subject->path())->assertSee($subject->description);

        $student = factory('App\User')->create();
        $this->be($student);
        $this->get($subject->path())->assertSee($subject->description);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_see_subject()
    {
        $subject = factory('App\Subject')->create();
        $this->get($subject->path())->assertRedirect('/login');
    }

    /** @test */
    public function an_owner_can_modify_subject()
    {
        $lecturer = factory('App\User')->state('lecturer')->create();
        $this->be($lecturer);

        $subject = factory('App\Subject')->create(['user_id' => auth()->id()]);

        $data = ['name' => 'Some Title', 'description' => 'Some Description'];

        $this->patch($subject->path(), $data);
        $this->get($subject->fresh()->path())->assertSee($data['name'])->assertSee($data['description']);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_modify_subject()
    {
        $lecturer = factory('App\User')->state('lecturer')->create();
        $this->be($lecturer);

        $subject = factory('App\Subject')->create();

        $data = ['name' => 'Some Title', 'description' => 'Some Description'];

        $this->patch($subject->path(), $data)->assertStatus(403);
        $subject = $subject->fresh();

        $this->get($subject->path())->assertDontSee($data['description']);
        $this->get($subject->path())->assertSee($subject->description);
    }

    /** @test */
    public function an_owner_can_delete_empty_subject()
    {
        $lecturer = factory('App\User')->state('lecturer')->create();
        $this->be($lecturer);

        $subject = factory('App\Subject')->create(['user_id' => auth()->id()]);

        $this->delete($subject->path())->assertStatus(302);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_empty_subject()
    {
        $this->be(factory('App\User')->state('lecturer')->create());
        $subject = factory('App\Subject')->create();

        $this->delete($subject->path())->assertStatus(403);
    }
}
