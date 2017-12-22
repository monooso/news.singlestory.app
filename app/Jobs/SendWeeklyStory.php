<?php

namespace App\Jobs;

use App\Constants\NewsSource;
use App\Exceptions\NoAvailableArticleException;
use App\Mail\WeeklyStory;
use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
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
        $articles = $this->getArticles();

        User::weekly()->each(function (User $user) use ($articles) {
            $article = $articles->get($user->source);

            if ($article) {
                Mail::to($user)->queue(new WeeklyStory($article));
            }
        });
    }

    protected function getArticles(): Collection
    {
        return collect(NewsSource::all())->mapWithKeys(function ($source) {
            try {
                return [$source => Article::thisWeek($source)];
            } catch (NoAvailableArticleException $e) {
                return [$source => null];
            }
        })->filter();
    }
}
