<?php

namespace Tests\Unit;

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
    public function it_returns_todays_article()
    {
        factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'retrieved_at' => Carbon::now()->subHours(25),
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'popularity'   => 99,
            'retrieved_at' => Carbon::now(),
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'popularity'   => 10,
            'retrieved_at' => Carbon::now()->subHours(5),
        ]);

        $article = factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'popularity'   => 20,
            'retrieved_at' => Carbon::now()->subHours(6),
        ]);

        $result = Article::today();

        $this->assertSame($article->id, $result->id);
    }

    /** @test */
    public function it_throws_an_exception_if_there_is_no_today_article()
    {
        $this->expectException(NoAvailableArticleException::class);
        Article::today();
    }

    /** @test */
    public function it_returns_this_weeks_article()
    {
        factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'retrieved_at' => Carbon::now()->subWeek(),
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'popularity'   => 99,
            'retrieved_at' => Carbon::now()->subDays(3),
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'popularity'   => 10,
            'retrieved_at' => Carbon::now()->subDays(2),
        ]);

        $article = factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'popularity'   => 20,
            'retrieved_at' => Carbon::now()->subDays(4),
        ]);

        $result = Article::thisWeek();

        $this->assertSame($article->id, $result->id);
    }

    /** @test */
    public function it_throws_an_exception_if_there_is_no_this_week_article()
    {
        $this->expectException(NoAvailableArticleException::class);
        Article::thisWeek();
    }
}
