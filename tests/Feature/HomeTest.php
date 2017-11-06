<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_access_the_home_page()
    {
        $response = $this->get(route('home'));

        $response->assertSuccessful();
        $response->assertViewIs('home');
    }

    /** @test */
    public function an_authenticated_user_cannot_access_the_home_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('home'));

        $response->assertRedirect(route('account'));
    }
}
