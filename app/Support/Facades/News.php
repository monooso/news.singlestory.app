<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

class News extends Facade
{
    /**
     * Returns the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'news';
    }
}
