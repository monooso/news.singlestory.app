<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_user_cannot_log_out()
    {
        $response = $this->get(route('logout'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_log_out()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('logout'));

        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
        User::flushEventListeners();
    }
}
