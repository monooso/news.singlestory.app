<?php

namespace Tests\Unit;

use App\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DuplicateTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_new_user_token_deletes_existing_user_tokens()
    {
        $user = factory(User::class)->create();
        $token = factory(Token::class)->create(['user_id' => $user->id]);

        Token::create(['user_id' => $user->id]);

        $this->assertDatabaseHas('tokens', ['user_id' => $user->id]);

        $this->assertDatabaseMissing('tokens', [
            'password' => $token->password,
            'user_id' => $user->id
        ]);
    }
}
