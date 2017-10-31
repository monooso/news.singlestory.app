<?php

namespace App\News\Responses;

use GuzzleHttp\Psr7\Response;

class NewYorkTimes
{
    /**
     * Parses the given NYTimes API response, and extracts the results array.
     *
     * @param Response $response
     *
     * @return array
     */
    public function parse(Response $response): array
    {
        return json_decode($response->getBody())->results;
    }
}
