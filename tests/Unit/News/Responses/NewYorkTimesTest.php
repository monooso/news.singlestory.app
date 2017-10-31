<?php

namespace Tests\News\Responses;

use App\News\Responses\NewYorkTimes;
use GuzzleHttp\Psr7\Response;
use Tests\Unit\News\TestCase;

class NewYorkTimesTest extends TestCase
{
    /** @test */
    public function it_returns_the_results_as_an_array()
    {
        $body = $this->loadResponseData(200);

        $response = new Response(200, [], $body);

        $articles = (new NewYorkTimes())->parse($response);

        $this->assertSame(20, count($articles));
    }
}
