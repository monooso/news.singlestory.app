<?php

namespace Tests\External;

use App\Constants\NewsSource;
use Tests\TestCase;

class NewsTest extends TestCase
{
    /** @test */
    public function it_retrieves_todays_most_popular_articles()
    {
        $key = 'news.' . NewsSource::BBC_NEWS;

        $result = app()->make($key)->mostPopularToday();

        $this->assertSame(config('news.limit'), $result->count());
    }

    /** @test */
    public function it_retrieves_this_weeks_most_popular_articles()
    {
        $key = 'news.' . NewsSource::REUTERS;

        $result = app()->make($key)->mostPopularThisWeek();

        $this->assertSame(config('news.limit'), $result->count());
    }

    /** @test */
    public function it_works_via_the_helper()
    {
        $result = news(NewsSource::INDEPENDENT)->mostPopularToday();

        $this->assertSame(config('news.limit'), $result->count());
    }
}
