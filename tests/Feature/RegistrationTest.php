<?php

namespace Tests\Feature;

use App\Mail\UserLoginToken;
use App\Mail\UserRegistrationToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_cannot_access_the_registration_form()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('home'));

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function an_authenticated_user_cannot_submit_the_registration_form()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('join'), ['email' => 'john@doe.com']);

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_next_step_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('join.next'));

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function registering_creates_a_new_user()
    {
        $response = $this->post(route('join'), ['email' => 'john@doe.com']);

        $response->assertRedirect(route('join.next'));
        $this->assertDatabaseHas('users', ['email' => 'john@doe.com']);
    }

    /** @test */
    public function registering_creates_a_one_time_password()
    {
        $this->post(route('join'), ['email' => 'john@doe.com']);

        $user = User::whereEmail('john@doe.com')->firstOrFail();

        $this->assertDatabaseHas('tokens', ['user_id' => $user->id]);
    }

    /** @test */
    public function registering_sends_a_login_token_email()
    {
        $this->post(route('join'), ['email' => 'john@doe.com']);

        $user = User::whereEmail('john@doe.com')->firstOrFail();

        Mail::assertQueued(
            UserRegistrationToken::class,
            function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            }
        );
    }

    /** @test */
    public function registering_with_an_invalid_email_displays_an_error()
    {
        $response = $this->post(route('join'), ['email' => 'nope']);

        $this->assertDatabaseMissing('users', ['email' => 'nope']);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function registering_with_a_duplicate_email_acts_as_a_login_request()
    {
        $user = factory(User::class)->create();

        $response = $this->post(route('join', ['email' => $user->email]));

        $response->assertRedirect(route('login.next'));

        Mail::assertQueued(
            UserLoginToken::class,
            function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            }
        );
    }

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
    }
}
