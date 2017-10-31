<?php

namespace App\Jobs;

use App\Constants\NewsWindow;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchDailyNews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $baseData = ['period' => NewsWindow::DAY];

        news()->mostPopularToday()
            ->each(function ($articleData) use ($baseData) {
                Article::create(array_merge($baseData, $articleData));
            });
    }
}
