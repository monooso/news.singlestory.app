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

    protected $source;

    public function __construct(string $source)
    {
        $this->source = $source;
    }

    public function handle()
    {
        $baseData = ['period' => NewsWindow::DAY, 'source' => $this->source];

        news($this->source)->mostPopularToday()
            ->each(function ($articleData) use ($baseData) {
                Article::create(array_merge($baseData, $articleData));
            });
    }
}
