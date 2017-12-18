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

    /** @test */
    public function it_transforms_each_result_into_a_normalized_array()
    {
        $item = (new NewsApi)->transform($this->getInput())->first();

        $this->assertEquals(
            ['abstract', 'byline', 'title', 'url'],
            array_keys($item)
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

    protected function getInput(): array
    {
        return $this->loadNewsApiResponseJson(200)->articles;
    }
}
