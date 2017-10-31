<?php

namespace Tests\Unit;

use App\Constants\NewsWindow;
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
            'retrieved_at' => Carbon::now()->subDay(),
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::WEEK,
            'popularity'   => 99,
            'retrieved_at' => Carbon::now(),
        ]);

        factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'popularity'   => 10,
            'retrieved_at' => Carbon::now(),
        ]);

        $article = factory(Article::class)->create([
            'period'       => NewsWindow::DAY,
            'popularity'   => 20,
            'retrieved_at' => Carbon::now(),
        ]);

        $result = Article::today();

        $this->assertSame($article->id, $result->id);
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
}
