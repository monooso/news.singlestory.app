<?php

namespace Tests\Unit;

use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenScopeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function results_are_limited_to_non_expired_tokens_by_default()
    {
        factory(Token::class)->create([
            'expires_at' => Carbon::now()->subMonths(2),
        ]);

        $token = factory(Token::class)->create([
            'expires_at' => Carbon::now()->addMonths(2),
        ]);

        $result = Token::all();

        $this->assertEquals(1, $result->count());
        $this->assertEquals($token->password, $result->first()->password);
    }

    /** @test */
    public function with_expired_includes_expired_tokens()
    {
        factory(Token::class)->create([
            'expires_at' => Carbon::now()->subMonths(2),
        ]);

        factory(Token::class)->create([
            'expires_at' => Carbon::now()->addMonths(2),
        ]);

        $result = Token::withExpired()->get();

        $this->assertEquals(2, $result->count());
    }

    public function setUp()
    {
        parent::setUp();
        Token::flushEventListeners();
    }
}
