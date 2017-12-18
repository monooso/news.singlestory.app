<?php

namespace App\Providers;

use App\Contracts\News\Client as ClientContract;
use App\Contracts\News\Response as ResponseContract;
use App\Contracts\News\Transformer as TransformerContract;
use App\News\Clients\NewYorkTimes as Client;
use App\News\News;
use App\News\Responses\NewYorkTimes as Response;
use App\News\Transformers\NewYorkTimes as Transformer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientContract::class, function () {
            return new Client(
                config('news.nytimes.api_key'),
                config('news.nytimes.section')
            );
        });

        $this->app->bind(ResponseContract::class, Response::class);

        $this->app->bind(TransformerContract::class, Transformer::class);

        $this->app->singleton('news', function ($app) {
            return new News(
                $app->make(ClientContract::class),
                $app->make(ResponseContract::class),
                $app->make(TransformerContract::class)
            );
        });
    }
}
