<?php

return [
    'default'     => env('DB_CONNECTION', 'sqlite'),
    'migrations'  => 'migrations',
    'connections' => [
        'development' => [
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

        'production'  => [
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

        'testing' => [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ],
    ],
];
