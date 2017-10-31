<?php

namespace Tests\Unit\Jobs;

use App\Constants\NewsWindow;
use App\Jobs\FetchDailyNews;
use App\Support\Facades\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class FetchDailyNewsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fetches_todays_news_and_saves_it_to_the_database()
    {
        News::shouldReceive('mostPopularToday')
            ->once()
            ->andReturn($this->getArticlesData());

        (new FetchDailyNews)->handle();

        $this->assertDatabaseHas('articles', [
            'external_id' => 'abc123',
            'period'      => NewsWindow::DAY,
        ]);

        $this->assertDatabaseHas('articles', [
            'external_id' => 'xyz987',
            'period'      => NewsWindow::DAY,
        ]);
    }

    protected function getArticlesData(): Collection
    {
        return collect([
            [
                'external_id' => 'abc123',
                'abstract'    => 'We were somewhere around Barstow...',
                'byline'      => 'Hunter S. Thompson',
                'popularity'  => 100,
                'title'       => 'Fear and Loathing in Las Vegas',
                'url'         => 'https://huntersthompson.com/fearandloathing',
            ],
            [
                'external_id' => 'xyz987',
                'abstract'    => 'All it comes down to is this: I feel like shit but look great.',
                'byline'      => 'Bret Easton Ellis',
                'popularity'  => 90,
                'title'       => 'American Psycho',
                'url'         => 'https://bateman4ever.com',
            ],
        ]);
    }
}
