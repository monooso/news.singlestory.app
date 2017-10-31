<?php

namespace App\Jobs;

use App\Mail\DailyStory;
use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendDailyStory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Send today's most popular article to all of the "daily" email recipients.
     */
    public function handle()
    {
        $article = Article::today();

        User::daily()->each(function (User $user) use ($article) {
            Mail::to($user)->queue(new DailyStory($article));
        });
    }
}
