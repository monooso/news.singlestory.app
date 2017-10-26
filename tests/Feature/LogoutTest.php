<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testAGuestUserCannotLogOut()
    {
        $response = $this->get(route('logout'));

        $response->assertRedirect(route('login'));
    }

    public function testAnAuthenticatedUserCanLogOut()
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
