<?php

namespace App\News\Transformers;

use App\Contracts\News\Transformer;
use Illuminate\Support\Collection;

class NewsApi implements Transformer
{
    public function transform(array $data): Collection
    {
        $limit = config('news.limit');

        return collect($data)
            ->reverse()
            ->values()
            ->map(function ($item, $index) {
                return [
                    'abstract'    => $item->description,
                    'byline'      => $item->author ?: $item->source->name,
                    'external_id' => $item->url,
                    'popularity'  => $index + 1,
                    'title'       => $item->title,
                    'url'         => $item->url,
                ];
            })
            ->reverse()
            ->take($limit)
            ->values();
    }
}
