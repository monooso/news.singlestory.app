<?php

namespace App\Contracts\News;

use Illuminate\Support\Collection;

interface Source
{
    /**
     * Returns the most popular articles today.
     *
     * @return Collection
     */
    public function mostPopularToday(): Collection;

    /**
     * Returns the most popular articles this week.
     *
     * @return Collection
     */
    public function mostPopularThisWeek(): Collection;
}
