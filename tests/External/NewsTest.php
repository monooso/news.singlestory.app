<?php

namespace Tests\External;

use App\Support\Facades\News;
use Tests\TestCase;

class NewsTest extends TestCase
{
    /** @test */
    public function it_retrieves_todays_most_popular_articles()
    {
        $result = app()->make('news')->mostPopularToday();

        $this->assertSame(config('news.limit'), $result->count());
    }

    /** @test */
    public function it_retrieves_this_weeks_most_popular_articles()
    {
        $result = app()->make('news')->mostPopularThisWeek();

        $this->assertSame(config('news.limit'), $result->count());
    }

    /** @test */
    public function it_works_via_the_facade()
    {
        $result = News::mostPopularToday();

        $this->assertSame(config('news.limit'), $result->count());
    }

    /** @test */
    public function it_works_via_the_helper()
    {
        $result = news()->mostPopularToday();

        $this->assertSame(config('news.limit'), $result->count());
    }
}
