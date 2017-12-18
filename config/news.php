<?php

return [
    // The number of "most popular" items to process.
    'limit' => 5,

    'newsapi' => ['api_key' => env('NEWSAPI_API_KEY')],

    'nytimes' => [
        'api_key' => env('NYTIMES_API_KEY'),
        'section' => env('NYTIMES_SECTION'),
    ],
];
