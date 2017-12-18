<?php

namespace App\News\Transformers;

use App\Contracts\News\Transformer;
use Illuminate\Support\Collection;

class NewsApi implements Transformer
{
    public function transform(array $data): Collection
    {
        $limit = config('news.limit');

        return collect($data)->map(function ($item) {
            return [
                'abstract'    => $item->description,
                'byline'      => $item->author,
                'title'       => $item->title,
                'url'         => $item->url,
            ];
        })->take($limit)->values();
    }
}
