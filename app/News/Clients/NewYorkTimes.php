<?php

namespace App\News\Clients;

use App\Contracts\News\Client as Contract;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class NewYorkTimes implements Contract
{
    use Mockable;

    protected $apiKey;
    protected $section;

    public function __construct(string $apiKey, string $section)
    {
        $this->apiKey = $apiKey;
        $this->section = $section;
    }

    public function getMostPopular(int $period): Response
    {
        $client = $this->makeClient();
        $url = $this->buildUrl($this->section, $period);

        return $client->get($url);
    }

    protected function makeClient(): Client
    {
        return new Client([
            'allow_redirects' => false,
            'handler'         => $this->handler,
            'headers'         => [
                'User-Agent' => 'news.singlestory/1.0',
                'Accept'     => 'application/json',
            ],
            'query'           => ['api-key' => $this->apiKey],
        ]);
    }

    protected function buildUrl(string $section, int $period): string
    {
        return sprintf(
            'https://api.nytimes.com/svc/mostpopular/v2/mostshared/%s/%d.json',
            $section,
            $period
        );
    }
}
