<?php

namespace App\News\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class NewYorkTimes
{
    protected $apiKey;
    protected $handler;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

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

    public function getMostPopular(string $section, int $period): Response
    {
        $client = $this->makeClient();
        $url = $this->buildUrl($section, $period);

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
