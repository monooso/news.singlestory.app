<?php

namespace Tests\Unit\News\Transformers;

use App\News\Transformers\NewsApi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Tests\Unit\News\TestCase;

class NewsApiTest extends TestCase
{
    /**
     * @var Collection
     */
    protected $transformed;

    /** @test */
    public function it_transforms_the_results_into_a_collection()
    {
        $transformed = (new NewsApi)->transform($this->getInput());

        $this->assertInstanceOf(Collection::class, $transformed);
    }

    protected function getInput(): array
    {
        return $this->loadNewsApiResponseJson(200)->articles;
    }

    /** @test */
    public function it_transforms_each_result_into_a_normalized_array()
    {
        $transformed = (new NewsApi)->transform($this->getInput());

        $this->assertEquals(
            ['abstract', 'byline', 'external_id', 'popularity', 'title', 'url'],
            array_keys($transformed->first())
        );
    }

    /** @test */
    public function it_extracts_the_abstract()
    {
        $transformed = (new NewsApi)->transform($this->getInput());

        $this->assertEquals(
            'First example description.',
            $transformed[0]['abstract']
        );
    }

    /** @test */
    public function it_extracts_the_byline()
    {
        $transformed = (new NewsApi)->transform($this->getInput());

        $this->assertEquals('First Author', $transformed[0]['byline']);
    }

    /** @test */
    public function it_uses_the_news_source_if_the_byline_is_empty()
    {
        $input = $this->getInput();
        $input[0]->author = '';

        $transformed = (new NewsApi)->transform($input);

        $this->assertEquals($input[0]->source->name, $transformed[0]['byline']);
    }

    /** @test */
    public function it_uses_the_url_as_the_external_id()
    {
        $transformed = (new NewsApi)->transform($this->getInput());

        $this->assertEquals(
            'https://example.com/first-article',
            $transformed[0]['external_id']
        );
    }

    /** @test */
    public function the_most_popular_article_is_the_first_item_in_the_input_array()
    {
    
        $input = $this->getInput();

        $transformed = (new NewsApi)->transform($input);

        $this->assertEquals(count($input), $transformed[0]['popularity']);
        $this->assertEquals(count($input) - 1, $transformed[1]['popularity']);
    }

    /** @test */
    public function it_extracts_the_title()
    {
        $transformed = (new NewsApi)->transform($this->getInput());

        $this->assertEquals('First Example Title', $transformed[0]['title']);
    }

    /** @test */
    public function it_extracts_the_url()
    {
        $transformed = (new NewsApi)->transform($this->getInput());

        $this->assertEquals(
            'https://example.com/first-article',
            $transformed[0]['url']
        );
    }

    /** @test */
    public function it_limits_the_result_count_according_to_the_config()
    {
        Config::set('news.limit', 5);

        $transformed = (new NewsApi)->transform($this->getInput());

        $this->assertSame(5, $transformed->count());
    }

    /** @test */
    public function it_does_not_limit_the_results_if_the_config_is_not_set()
    {
        Config::set('news.limit', null);

        $input = $this->getInput();

        $transformed = (new NewsApi)->transform($input);

        $this->assertSame(count($input), $transformed->count());
    }
}
