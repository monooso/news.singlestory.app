<?php

namespace App\News\Clients;

use GuzzleHttp\HandlerStack;

trait Mockable
{
    protected $handler;

    /**
     * Ew. This method exists for the sole purpose of mocking the API calls
     * during testing, as per the Guzzle docs.
     *
     * @see http://docs.guzzlephp.org/en/stable/testing.html
     *
     * @param HandlerStack $handler
     */
    public function setHandler(HandlerStack $handler)
    {
        $this->handler = $handler;
    }
}
