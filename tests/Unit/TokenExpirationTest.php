<?php

namespace Tests\Unit;

use App\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TokenExpirationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_new_instance_sets_expires_at()
    {
        $lifetime = 30;

        Config::set('token.lifetime', $lifetime);

        $user = factory(User::class)->create();
        $token = Token::create(['user_id' => $user->id]);

        $this->assertTimeWithin(
            Carbon::now()->addMinutes($lifetime),
            $token->expires_at,
            2
        );
    }

    /** @test */
    public function saving_a_new_instance_sets_expires_at()
    {
        $lifetime = 45;

        Carbon::setTestNow(Carbon::now()->subDays(3));
        Config::set('token.lifetime', $lifetime);

        $user = factory(User::class)->create();

        $token = new Token(['user_id' => $user->id]);
        $token->save();

        $this->assertTimeWithin(Carbon::now()->addMinutes($lifetime), $token->expires_at, 1);
    }

    /** @test */
    public function expires_at_may_not_be_modified()
    {
        Carbon::setTestNow(Carbon::now()->subMonths(8));

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
