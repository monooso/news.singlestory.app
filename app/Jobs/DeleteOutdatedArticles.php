<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteOutdatedArticles implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function handle()
    {
        Article::outdated()->delete();
    }
}
