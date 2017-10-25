<?php

namespace Tests\Unit;

use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenScopeTest extends TestCase
{
    use RefreshDatabase;

    public function testResultsAreLimitedToNonExpiredTokensByDefault()
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

    public function testWithExpiredIncludesExpiredTokens()
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
