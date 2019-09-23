<?php

namespace Tests\Unit\Jobs;

use App\Constants\EmailSchedule;
use App\Constants\NewsSource;
use App\Constants\NewsWindow;
use App\Jobs\SendWeeklyStory;
use App\Mail\DailyStory;
use App\Mail\WeeklyStory;
use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendWeeklyStoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_does_nothing_if_there_is_no_article()
    {
        factory(User::class)->create(['schedule' => EmailSchedule::WEEKLY]);

        Mail::fake();

        (new SendWeeklyStory())->handle();

        Mail::assertNotQueued(WeeklyStory::class);
    }

    /** @test */
    public function it_honors_the_users_chosen_news_source()
    {
        factory(User::class)->create([
            'schedule' => EmailSchedule::WEEKLY,
            'source'   => NewsSource::BBC_NEWS,
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'retrieved_at' => Carbon::now()->subDays(2),
            'source'       => NewsSource::THE_WASHINGTON_POST,
        ]);

        Mail::fake();

        (new SendWeeklyStory())->handle();

        Mail::assertNotQueued(DailyStory::class);
    }

    /** @test */
    public function it_sends_an_article_to_the_weekly_recipients()
    {
        factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'retrieved_at' => Carbon::now(),
            'source'       => NewsSource::ASSOCIATED_PRESS,
        ]);

        $article = factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'popularity'   => 20,
            'retrieved_at' => Carbon::now(),
            'source'       => NewsSource::ASSOCIATED_PRESS,
        ]);

        factory(User::class)->create([
            'schedule' => EmailSchedule::DAILY,
            'source'   => NewsSource::ASSOCIATED_PRESS,
        ]);

        factory(User::class)->create([
            'email'    => 'john@doe.com',
            'schedule' => EmailSchedule::WEEKLY,
            'source'   => NewsSource::ASSOCIATED_PRESS,
        ]);

        factory(User::class)->create([
            'email'    => 'jane@doe.com',
            'schedule' => EmailSchedule::WEEKLY,
            'source'   => NewsSource::ASSOCIATED_PRESS,
        ]);

        Mail::fake();

        (new SendWeeklyStory)->handle();

        Mail::assertQueued(WeeklyStory::class, 2);

        Mail::assertQueued(WeeklyStory::class, function ($mail) use ($article) {
            return $mail->article->id === $article->id
                && $mail->hasTo('john@doe.com');
        });

        Mail::assertQueued(WeeklyStory::class, function ($mail) use ($article) {
            return $mail->article->id === $article->id
                && $mail->hasTo('jane@doe.com');
        });
    }
}
