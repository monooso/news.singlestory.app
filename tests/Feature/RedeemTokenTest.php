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

    public function xtestRedeemMissingToken()
    {
        $response = $this->get(route('login.validate-token', 'abc123'));

        $response->assertRedirect(route('login.invalid-token'));
    }

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
        User::flushEventListeners();
    }
}
