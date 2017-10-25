<?php

namespace Tests\Unit;

use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TokenExpirationTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatingANewInstanceSetsExpiresAt()
    {
        $user = factory(User::class)->create();
        $token = Token::create(['user_id' => $user->id]);

        $this->assertTimeWithin(
            Carbon::now()->addMinutes(15),
            $token->expires_at,
            1
        );
    }

    public function testSavingANewInstanceSetsExpiresAt()
    {
        $user = factory(User::class)->create();

        $token = new Token(['user_id' => $user->id]);
        $token->save();

        $this->assertTimeWithin(
            Carbon::now()->addMinutes(15),
            $token->expires_at,
            1
        );
    }

    public function testExpiresAtMayNotBeModified()
    {
        $expiresAt = Carbon::now()->subYear();

        // Manually add a token with a very old expires_at date.
        $user = factory(User::class)->create();

        $tokenId = DB::table('tokens')->insertGetId([
            'expires_at' => $expiresAt,
            'user_id'    => $user->id,
            'password'   => 'password',
        ]);

        $token = Token::withExpired()->whereId($tokenId)->firstOrFail();
        $token->expires_at = Carbon::now()->addYear();
        $token->save();
        $token->refresh();

        $this->assertTimeWithin($expiresAt, $token->expires_at, 1);
    }
}
