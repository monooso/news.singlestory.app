<?php

namespace Tests\Feature;

use App\Mail\UserRegistrationToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
    }

    public function testAnAuthenticatedUserCannotAccessTheRegistrationForm()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('home'));

        $response->assertRedirect(route('account'));
    }

    public function testAnAuthenticatedUserCannotSubmitTheRegistrationForm()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->post(route('join'), ['email' => 'john@doe.com']);

        $response->assertRedirect(route('account'));
    }

    public function testAnAuthenticatedUserCannotViewTheNextStepPage()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get(route('join.next'));

        $response->assertRedirect(route('account'));
    }

    public function testRegisteringCreatesANewUser()
    {
        $response = $this->post(route('join'), ['email' => 'john@doe.com']);

        $response->assertRedirect(route('join.next'));
        $this->assertDatabaseHas('users', ['email' => 'john@doe.com']);
    }

    public function testRegisteringCreatesAOneTimePassword()
    {
        $this->post(route('join'), ['email' => 'john@doe.com']);

        $user = User::whereEmail('john@doe.com')->firstOrFail();

        $this->assertDatabaseHas('tokens', ['user_id' => $user->id]);
    }

    public function testRegisteringSendsALoginTokenEmail()
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

    public function testRegisteringWithAnInvalidEmailDisplaysAnError()
    {
        $response = $this->post(route('join'), ['email' => 'nope']);

        $this->assertDatabaseMissing('users', ['email' => 'nope']);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']);
    }

    public function testRegisteringWithADuplicateEmailActsAsALoginRequest()
    {
        $user = factory(User::class)->create();

        $response = $this->post(route('join', ['email' => $user->email]));

        $response->assertRedirect(route('login.next'));
    }
}
