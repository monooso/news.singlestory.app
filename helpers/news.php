<?php

use App\Contracts\News\Source;

if (! function_exists('news')) {
    /**
     * Global news helper function.
     *
     * @param string $source The news source (e.g. 'bbc-news').
     *
     * @return \App\News\News
     */
    function news(string $source): Source
    {
        return app()->make('news.' . $source);
    }
}
