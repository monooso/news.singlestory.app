<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AccountDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_user_cannot_access_the_account_dashboard()
    {
        $response = $this->get(route('account'));

        $response->assertRedirect(route('login'));
    }

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        User::flushEventListeners();
    }
}
