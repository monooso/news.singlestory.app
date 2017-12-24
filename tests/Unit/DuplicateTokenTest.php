<?php

namespace Tests\Unit;

use App\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DuplicateTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_token_deletes_active_user_tokens()
    {
        $user = factory(User::class)->create();
        $token = factory(Token::class)->create(['user_id' => $user->id]);

        Token::create(['user_id' => $user->id]);

        $this->assertDatabaseHas('tokens', ['user_id' => $user->id]);

        $this->assertDatabaseMissing('tokens', [
            'password' => $token->password,
            'user_id'  => $user->id,
        ]);
    }

    /** @test */
    public function creating_a_token_deletes_expired_user_tokens()
    {
        $user = factory(User::class)->create();

        // We have to manually create the token for this test.
        DB::table('tokens')->insert([
            'user_id'    => $user->id,
            'created_at' => Carbon::now()->subMinutes(20),
            'expires_at' => Carbon::now()->subMinutes(5),
            'password'   => 'abc123',
            'updated_at' => Carbon::now()->subMinutes(20),
        ]);

        Token::create(['user_id' => $user->id]);

        $this->assertDatabaseHas('tokens', ['user_id' => $user->id]);

        $this->assertDatabaseMissing('tokens', [
            'password' => 'abc123',
            'user_id'  => $user->id,
        ]);
    }
}
