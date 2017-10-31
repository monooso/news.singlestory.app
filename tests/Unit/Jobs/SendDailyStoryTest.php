<?php

namespace Tests\Unit\Jobs;

use App\Constants\EmailSchedule;
use App\Constants\NewsWindow;
use App\Jobs\SendDailyStory;
use App\Mail\DailyStory;
use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendDailyStoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_an_article_to_the_daily_recipients()
    {
        factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'retrieved_at' => Carbon::now(),
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'popularity'   => 10,
            'retrieved_at' => Carbon::now(),
        ]);

        $article = factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'popularity'   => 20,
            'retrieved_at' => Carbon::now(),
        ]);

        factory(User::class)->create(['schedule' => EmailSchedule::WEEKLY]);

        factory(User::class)->create([
            'email'    => 'john@doe.com',
            'schedule' => EmailSchedule::DAILY,
        ]);

        factory(User::class)->create([
            'email'    => 'jane@doe.com',
            'schedule' => EmailSchedule::DAILY,
        ]);

        Mail::fake();

        (new SendDailyStory)->handle();

        Mail::assertQueued(DailyStory::class, 2);

        Mail::assertQueued(DailyStory::class, function ($mail) use ($article) {
            return $mail->article->id === $article->id
                && $mail->hasTo('john@doe.com');
        });

        Mail::assertQueued(DailyStory::class, function ($mail) use ($article) {
            return $mail->article->id === $article->id
                && $mail->hasTo('jane@doe.com');
        });
    }
}
