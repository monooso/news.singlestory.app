<?php

namespace App\News\Responses;

use App\Contracts\News\Response as Contract;
use GuzzleHttp\Psr7\Response;

class NewsApi implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function parse(Response $response): array
    {
        return json_decode($response->getBody())->articles;
    }
}
