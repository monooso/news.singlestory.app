<?php

namespace Tests\Unit;

use App\Constants\NewsSource;
use App\Constants\NewsWindow;
use App\Exceptions\NoAvailableArticleException;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_outdated_articles()
    {
        factory(Article::class)->create(['retrieved_at' => Carbon::now()->subDays(14)]);

        $outdated = factory(Article::class)->create([
            'retrieved_at' => Carbon::now()->subDays(15),
        ]);

        /** @var \Illuminate\Database\Eloquent\Collection $result */
        $result = Article::outdated()->get();

        $this->assertSame(1, $result->count());
        $this->assertSame($result->first()->id, $outdated->id);
    }

    /** @test */
    public function it_returns_todays_article()
    {
        factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'retrieved_at' => Carbon::now()->subHours(25),
            'source'       => NewsSource::INDEPENDENT,
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'popularity'   => 99,
            'retrieved_at' => Carbon::now(),
            'source'       => NewsSource::INDEPENDENT,
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'popularity'   => 10,
            'retrieved_at' => Carbon::now()->subHours(5),
            'source'       => NewsSource::INDEPENDENT,
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'popularity'   => 99,
            'retrieved_at' => Carbon::now()->subHours(5),
            'source'       => NewsSource::BREITBART_NEWS,
        ]);

        $article = factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'popularity'   => 20,
            'retrieved_at' => Carbon::now()->subHours(6),
            'source'       => NewsSource::INDEPENDENT,
        ]);

        $result = Article::today(NewsSource::INDEPENDENT);

        $this->assertSame($article->id, $result->id);
    }

    /** @test */
    public function it_throws_an_exception_if_there_is_no_today_article()
    {
        $this->expectException(NoAvailableArticleException::class);

        Article::today(NewsSource::REUTERS);
    }

    /** @test */
    public function it_returns_this_weeks_article()
    {
        factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'retrieved_at' => Carbon::now()->subWeek(),
            'source'       => NewsSource::INDEPENDENT,
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'popularity'   => 99,
            'retrieved_at' => Carbon::now()->subDays(3),
            'source'       => NewsSource::INDEPENDENT,
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'popularity'   => 10,
            'retrieved_at' => Carbon::now()->subDays(2),
            'source'       => NewsSource::INDEPENDENT,
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'popularity'   => 99,
            'retrieved_at' => Carbon::now()->subDays(4),
            'source'       => NewsSource::FOX_NEWS,
        ]);

        $article = factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'popularity'   => 20,
            'retrieved_at' => Carbon::now()->subDays(4),
            'source'       => NewsSource::INDEPENDENT,
        ]);

        $result = Article::thisWeek(NewsSource::INDEPENDENT);

        $this->assertSame($article->id, $result->id);
    }

    /** @test */
    public function it_throws_an_exception_if_there_is_no_this_week_article()
    {
        $this->expectException(NoAvailableArticleException::class);

        Article::thisWeek(NewsSource::INDEPENDENT);
    }
}
