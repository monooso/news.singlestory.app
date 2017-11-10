<?php

namespace Tests\Unit;

use App\Models\Token;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedeemTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function redeeming_a_token_deletes_it()
    {
        $token = factory(Token::class)->create();

        $this->assertDatabaseHas('tokens', ['id' => $token->id]);

        $token->redeem();

        $this->assertDatabaseMissing('tokens', ['id' => $token->id]);
    }
}
