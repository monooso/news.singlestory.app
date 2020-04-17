<?php

namespace Tests\Feature;

use App\Mail\UserLoginToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_cannot_access_the_login_form()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('login'));

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function an_authenticated_user_cannot_submit_the_login_form()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('login'), ['email' => $user->email]);

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_next_step_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('login.next'));

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function login_form()
    {
        $response = $this->get(route('login'));

        $response->assertSuccessful();
        $response->assertViewIs('login.show');
    }

    /** @test */
    public function login_creates_a_one_time_password()
    {
        $user = factory(User::class)->create();

        $this->post(route('login'), ['email' => $user->email]);

        $this->assertDatabaseHas('tokens', ['user_id' => $user->id]);
    }

    /** @test */
    public function login_with_an_unknown_user_redirects_with_errors()
    {
        $response = $this->post(route('login'), ['email' => 'john@doe.com']);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function login_redirects_to_the_next_step()
    {
        $user = factory(User::class)->create();

        $response = $this->post(route('login'), ['email' => $user->email]);

        $response->assertRedirect(route('login.next'));
    }

    /** @test */
    public function login_sends_an_email()
    {
        $user = factory(User::class)->create();

        $this->post(route('login'), ['email' => $user->email]);

        Mail::assertQueued(
            UserLoginToken::class,
            function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            }
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        User::flushEventListeners();
    }
}
