<?php

namespace App\Providers;

use App\Constants\NewsSource;
use App\News\Clients\NewsApi as Client;
use App\News\News;
use App\News\Responses\NewsApi as Response;
use App\News\Transformers\NewsApi as Transformer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::if('developer', function () {
            return Horizon::check(app()->request);
        });
    }

    public function register()
    {
        foreach (NewsSource::all() as $source) {
            $this->registerNewsSource($source);
        }
    }

    protected function registerNewsSource(string $source)
    {
        $this->app->singleton('news.' . $source, function ($app) use ($source) {
            return new News(
                new Client(config('news.newsapi.api_key'), $source),
                new Response(),
                new Transformer()
            );
        });
    }
}
