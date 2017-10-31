<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootMostPopularCollectionMacro();
    }

    /**
     * Adds a `mostPopular` macro to the Collection class, which returns the
     * most popular items articles from a collection.
     */
    protected function bootMostPopularCollectionMacro()
    {
        Collection::macro('mostPopular', function (int $count = null) {
            $collection = $this->sortBy('popularity')->reverse()->values();

            if (!is_null($count)) {
                $collection = $collection->take($count)->values();
            }

            return $collection;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
