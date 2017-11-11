<?php

namespace App\News;

use App\Constants\NewsWindow;
use App\Contracts\News\Source;
use App\News\Clients\NewYorkTimes as Client;
use App\News\Responses\NewYorkTimes as Response;
use App\News\Transformers\NewYorkTimes as Transformer;
use Illuminate\Support\Collection;

class NewYorkTimes implements Source
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Transformer
     */
    protected $transformer;

    public function __construct(
        Client $client,
        Response $response,
        Transformer $transformer
    ) {
        $this->client = $client;
        $this->response = $response;
        $this->transformer = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    public function mostPopularToday(): Collection
    {
        return $this->mostPopular(NewsWindow::DAY);
    }

    /**
     * Returns a collection of the most popular articles published during the
     * given time period.
     *
     * @param int $period The time period, in days.
     *
     * @return Collection
     */
    protected function mostPopular(int $period): Collection
    {
        $response = $this->client->getMostPopular(
            config('news.nytimes.section'), $period);

        $results = $this->response->parse($response);

        return $this->transformer->transform($results);
    }

    /**
     * {@inheritdoc}
     */
    public function mostPopularThisWeek(): Collection
    {
        return $this->mostPopular(NewsWindow::WEEK);
    }
}
