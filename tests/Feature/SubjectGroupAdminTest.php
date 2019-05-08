<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectGroupAdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_may_delete_subject_group()
    {
        $this->withoutExceptionHandling();

        $group = factory('App\SubjectGroup')->create();

        $this->be(factory('App\User')->state('admin')->create());

        $this->delete($group->path());

        $this->assertDatabaseMissing('subject_groups', ['name' => $group->name, 'code' => $group->code]);
    }
}
