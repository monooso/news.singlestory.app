<?php

namespace Tests\News\Clients;

use App\News\Clients\NewYorkTimes;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\Unit\News\TestCase;

class NewYorkTimesTest extends TestCase
{
    /** @test */
    public function it_retrieves_the_most_popular_daily_articles()
    {
        $key = config('news.nytimes.api_key');

        $expected = new Response(200);

        $handler = HandlerStack::create(new MockHandler([$expected]));

        $client = new NewYorkTimes($key, 'any-section-will-do');
        $client->setHandler($handler);

        $actual = $client->getMostPopular(100);

        $this->assertSame($expected, $actual);
    }
}
