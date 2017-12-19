<?php

namespace App\Contracts\News;

use GuzzleHttp\Psr7\Response;

interface Client
{
    /**
     * Returns the most popular articles for the given time period.
     *
     * @param int $period The time period, in days.
     *
     * @return Response
     */
    public function getMostPopular(int $period): Response;
}
