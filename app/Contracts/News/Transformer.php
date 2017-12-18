<?php

namespace App\Contracts\News;

use Illuminate\Support\Collection;

interface Transformer
{
    /**
     * Transform the given array of data into a normalised collection.
     *
     * @param array $data
     *
     * @return Collection
     */
    public function transform(array $data): Collection;
}
