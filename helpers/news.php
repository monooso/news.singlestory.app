<?php

if (! function_exists('news')) {
    /**
     * Global news helper function.
     *
     * @return \App\News\News
     */
    function news()
    {
        return app()->make('news');
    }
}
