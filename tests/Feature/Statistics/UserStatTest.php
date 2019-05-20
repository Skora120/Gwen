<?php

namespace Tests\Feature\Statistics;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserStatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_user_may_see_statistics_page()
    {
        $this->withoutExceptionHandling();

        $this->be(factory('App\User')->create());

        $this->get('/statistics')->assertStatus(200);
    }
}
