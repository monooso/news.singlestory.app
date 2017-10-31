<?php

namespace Tests\Unit;

use App\Constants\EmailSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_users_who_wish_to_receive_a_daily_email()
    {
        factory(User::class)->create(['schedule' => EmailSchedule::WEEKLY]);

        $user = factory(User::class)->create([
            'schedule' => EmailSchedule::DAILY,
        ]);

        $result = User::daily();

        $this->assertCount(1, $result);
        $this->assertSame($user->id, $result->first()->id);
    }

    /** @test */
    public function it_returns_users_who_wish_to_receive_a_weekly_email()
    {
        factory(User::class)->create(['schedule' => EmailSchedule::DAILY]);

        $user = factory(User::class)->create([
            'schedule' => EmailSchedule::WEEKLY,
        ]);

        $result = User::weekly();

        $this->assertCount(1, $result);
        $this->assertSame($user->id, $result->first()->id);
    }
}
