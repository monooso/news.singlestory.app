<?php

namespace App\Jobs;

use App\Constants\NewsSource;
use App\Exceptions\NoAvailableArticleException;
use App\Mail\DailyStory;
use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class SendDailyStory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Send today's most popular article to all of the "daily" email recipients.
     */
    public function handle()
    {
        $articles = $this->getArticles();

        User::daily()->each(function (User $user) use ($articles) {
            $article = $articles->get($user->source);

            if ($article) {
                Mail::to($user)->queue(new DailyStory($article));
            }
        });
    }

    protected function getArticles(): Collection
    {
        return collect(NewsSource::all())->mapWithKeys(function ($source) {
            try {
                return [$source => Article::today($source)];
            } catch (NoAvailableArticleException $e) {
                return [$source => null];
            }
        })->filter();
    }
}
