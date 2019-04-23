<?php

namespace Tests\Unit\Jobs;

use App\Jobs\DeleteOutdatedArticles;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteOutdatedArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_deletes_outdated_articles_from_the_database()
    {
        $current = factory(Article::class)->create(['retrieved_at' => now()->subDays(14)]);
        $outdated = factory(Article::class)->create(['retrieved_at' => now()->subDays(15)]);

        (new DeleteOutdatedArticles())->handle();

        $this->assertDatabaseHas('articles', ['id' => $current->id]);
        $this->assertDatabaseMissing('articles', ['id' => $outdated->id]);
    }
}
