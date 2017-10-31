<?php

namespace App\Providers;

use App\News\Clients\NewYorkTimes as Client;
use App\News\NewYorkTimes;
use App\News\Responses\NewYorkTimes as Response;
use App\News\Transformers\NewYorkTimes as Transformer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('news', function () {
            return new NewYorkTimes(
                new Client(config('news.nytimes.api_key')),
                new Response(),
                new Transformer()
            );
        });
    }
}
