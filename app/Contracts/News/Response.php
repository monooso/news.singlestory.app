<?php

namespace App\Contracts\News;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

interface Response
{
    /**
     * Parses the given API response, and extracts the news articles.
     *
     * @param GuzzleResponse $response
     *
     * @return array
     */
    public function parse(GuzzleResponse $response): array;
}
