<?php

namespace Tests\Feature;

use App\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RedeemTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testRedeemValidToken()
    {
        $token = factory(Token::class)->create();

        $response = $this->get(route('login.validate-token', $token->password));

        $response->assertRedirect(route('account'));
    }

    public function testRedeemValidTokenLogsUserIn()
    {
        $token = factory(Token::class)->create();

        $this->get(route('login.validate-token', $token->password));

        $this->assertAuthenticatedAs($token->user);
    }

    public function testRedeemValidTokenDeletesTheToken()
    {
        $token = factory(Token::class)->create();

        $this->get(route('login.validate-token', $token->password));

        $this->assertDatabaseMissing('tokens', ['id' => $token->id]);
    }

    public function testRedeemInvalidTokenRedirectsToInvalidTokenPage()
    {
        $response = $this->get(route('login.validate-token', 'abc123'));

        $response->assertStatus(404);
        $response->assertSeeText('abc123 is not a valid token');
    }

    public function testRedeemInvalidTokenDoesNotLogUserIn()
    {
        $this->get(route('login.validate-token', 'abc123'));

        $this->assertGuest();
    }

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
        User::flushEventListeners();
    }
}
