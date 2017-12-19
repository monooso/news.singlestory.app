<?php

namespace Tests\News\Responses;

use App\News\Responses\NewsApi;
use GuzzleHttp\Psr7\Response;
use Tests\Unit\News\TestCase;

class NewsApiTest extends TestCase
{
    /** @test */
    public function it_returns_the_results_as_an_array()
    {
        $body = $this->loadNewsApiResponseData(200);

        $response = new Response(200, [], $body);

        $articles = (new NewsApi())->parse($response);

        $this->assertSame(10, count($articles));
    }
}
