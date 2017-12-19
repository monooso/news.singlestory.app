<?php

namespace App\News\Clients;

use App\Contracts\News\Client as Contract;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Carbon;

class NewsApi implements Contract
{
    use Mockable;

    protected $apiKey;
    protected $source;

    public function __construct(string $apiKey, string $source)
    {
        $this->apiKey = $apiKey;
        $this->source = $source;
    }

    public function getMostPopular(int $period): Response
    {
        $client = $this->makeClient();

        $url = $this->buildUrl($this->source, $period);

        return $client->get($url);
    }

    protected function makeClient(): Client
    {
        return new Client([
            'allow_redirects' => false,
            'handler'         => $this->handler,
            'headers'         => [
                'Accept'     => 'application/json',
                'User-Agent' => 'news.singlestory/1.0',
                'X-Api-Key'  => $this->apiKey,
            ],
        ]);
    }

    protected function buildUrl(string $source, int $period): string
    {
        $url = 'https://newsapi.org/v2/top-headlines?sources=%s&from=%s&to=%s&sortBy=popularity';
        $from = Carbon::now()->subDays($period);
        $to = Carbon::now();

        return sprintf($url, $source, $from, $to);
    }
}
