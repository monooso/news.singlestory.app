<?php

namespace App\Jobs;

use App\Exceptions\NoAvailableArticleException;
use App\Mail\WeeklyStory;
use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWeeklyStory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Send this week's most popular article to all of the "weekly" email
     * recipients.
     */
    public function handle()
    {
        try {
            $article = Article::thisWeek();
        } catch (NoAvailableArticleException $e) {
            return;
        }

        User::weekly()->each(function (User $user) use ($article) {
            Mail::to($user)->queue(new WeeklyStory($article));
        });
    }
}
