<?php

return [

    'default' => env('MAIN_MAILER', 'smtp'),

    'mailers' => [
        'smtp' => [
            'transport'  => 'smtp',
            'host'       => env('MAIL_HOST'),
            'port'       => env('MAIL_PORT'),
            'encryption' => env('MAIL_ENCRYPTION'),
            'username'   => env('MAIL_USERNAME'),
            'password'   => env('MAIL_PASSWORD'),
            'timeout'    => null,
        ],

        'ses'      => ['transport' => 'ses'],
        'mailgun'  => ['transport' => 'mailgun'],
        'postmark' => ['transport' => 'postmark'],
        'sendmail' => ['transport' => 'sendmail', 'path' => '/usr/sbin/sendmail -bs'],
        'log'      => ['transport' => 'log', 'channel' => env('MAIL_LOG_CHANNEL')],
        'array'    => ['transport' => 'array'],
    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS'),
        'name'    => env('MAIL_FROM_NAME'),
    ],

    'markdown' => [
        'theme' => 'default',
        'paths' => [resource_path('views/vendor/mail')],
    ],
];
