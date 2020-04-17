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

    /** @test */
    public function an_authenticated_user_cannot_redeem_a_token()
    {
        $user = factory(User::class)->create();
        $token = factory(Token::class)->create();

        $this->be($user);

        $response = $this->get(route('login.validate-token', $token->password));

        $response->assertRedirect(route('account'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function redeem_valid_token()
    {
        $token = factory(Token::class)->create();

        $response = $this->get(route('login.validate-token', $token->password));

        $response->assertRedirect(route('account'));
    }

    /** @test */
    public function redeem_valid_token_logs_user_in()
    {
        $token = factory(Token::class)->create();

        $this->get(route('login.validate-token', $token->password));

        $this->assertAuthenticatedAs($token->user);
    }

    /** @test */
    public function redeem_valid_token_deletes_the_token()
    {
        $token = factory(Token::class)->create();

        $this->get(route('login.validate-token', $token->password));

        $this->assertDatabaseMissing('tokens', ['id' => $token->id]);
    }

    /** @test */
    public function redeem_invalid_token_redirects_to_invalid_token_page()
    {
        $response = $this->get(route('login.validate-token', 'abc123'));

        $response->assertStatus(404);
        $response->assertSeeText('abc123 is not a valid token');
    }

    /** @test */
    public function redeem_invalid_token_does_not_log_user_in()
    {
        $this->get(route('login.validate-token', 'abc123'));

        $this->assertGuest();
    }

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        User::flushEventListeners();
    }
}
