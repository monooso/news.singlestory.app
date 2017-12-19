<?php

namespace Tests\News\Clients;

use App\News\Clients\NewsApi;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\Unit\News\TestCase;

class NewsApiTest extends TestCase
{
    /** @test */
    public function it_retrieves_the_most_popular_daily_articles()
    {
        $key = config('news.newsapi.api_key');

        $expected = new Response(200);

        $handler = HandlerStack::create(new MockHandler([$expected]));

        $client = new NewsApi($key, 'any-source-will-do');
        $client->setHandler($handler);

        $actual = $client->getMostPopular(100);

        $this->assertSame($expected, $actual);
    }
}
