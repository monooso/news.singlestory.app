<?php

return [
    // The number of "most popular" items to process.
    'limit'   => 5,

    // NYTimes-specific settings.
    'nytimes' => [
        'api_key' => env('NYTIMES_API_KEY'),
        'section' => env('NYTIMES_SECTION'),
    ],
];
