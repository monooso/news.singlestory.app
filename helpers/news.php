<?php

if (!function_exists('news')) {
    /**
     * Global news helper function.
     *
     * @return \App\News\NewYorkTimes
     */
    function news()
    {
        return app()->make('news');
    }
}

