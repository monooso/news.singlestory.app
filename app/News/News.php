<?php

namespace App\News;

use App\Constants\NewsWindow;
use App\Contracts\News\Client;
use App\Contracts\News\Response;
use App\Contracts\News\Source;
use App\Contracts\News\Transformer;
use Illuminate\Support\Collection;

class News implements Source
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
        $response = $this->client->getMostPopular($period);

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
