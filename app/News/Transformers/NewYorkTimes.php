<?php

namespace App\News\Transformers;

use Illuminate\Support\Collection;

class NewYorkTimes
{
    public function transform(array $data): Collection
    {
        $limit = config('news.limit');

        return collect($data)->map(function ($item) {
            return [
                'abstract'   => $item->abstract,
                'byline'     => $item->byline,
                'id'         => $item->asset_id,
                'popularity' => $item->total_shares,
                'title'      => $item->title,
                'url'        => $item->url,
            ];
        })->mostPopular($limit);
    }
}
