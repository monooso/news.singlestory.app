<?php

return [
    'default'     => env('DB_CONNECTION', 'mysql'),
    'migrations'  => 'migrations',
    'connections' => [
        'mysql' => [
            'driver'      => 'mysql',
            'host'        => env('DB_HOST'),
            'port'        => env('DB_PORT'),
            'database'    => env('DB_DATABASE'),
            'username'    => env('DB_USERNAME'),
            'password'    => env('DB_PASSWORD'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset'     => 'utf8mb4',
            'collation'   => 'utf8mb4_unicode_ci',
            'prefix'      => '',
            'strict'      => true,
            'engine'      => null,
        ],
    ],

    'redis' => [
        'client'  => 'phpredis',
        'default' => [
            'host'     => env('REDIS_HOST'),
            'password' => env('REDIS_PASSWORD'),
            'port'     => env('REDIS_PORT'),
            'database' => 0,
        ],
    ],
];
