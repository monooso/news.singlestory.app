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

    public function testAnAuthenticatedUserCannotAccessTheLoginForm()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('login'));

        $response->assertRedirect(route('account'));
    }

    public function testAnAuthenticatedUserCannotSubmitTheLoginForm()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('login'), ['email' => $user->email]);

        $response->assertRedirect(route('account'));
    }

    public function testAnAuthenticatedUserCannotViewTheNextStepPage()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('login.next'));

        $response->assertRedirect(route('account'));
    }

    public function testLoginForm()
    {
        $response = $this->get(route('login'));

        $response->assertSuccessful();
        $response->assertViewIs('login.show');
    }

    public function testLoginCreatesAOneTimePassword()
    {
        $user = factory(User::class)->create();

        $this->post(route('login'), ['email' => $user->email]);

        $this->assertDatabaseHas('tokens', ['user_id' => $user->id]);
    }

    public function testLoginWithAnUnknownUserRedirectsWithErrors()
    {
        $response = $this->post(route('login'), ['email' => 'john@doe.com']);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']);
    }

    public function testLoginRedirectsToTheNextStep()
    {
        $user = factory(User::class)->create();

        $response = $this->post(route('login'), ['email' => $user->email]);

        $response->assertRedirect(route('login.next'));
    }

    public function testLoginSendsAnEmail()
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

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
        User::flushEventListeners();
    }
}
