<?php

return [
    'default' => env('DB_CONNECTION', 'mongodb'),

    'migrations' => 'migrations',

    'connections' => [
        'mongodb' => [
            'driver' => 'mongodb',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 27017),
            'database' => env('DB_DATABASE', 'spaceflight_db'),
            'username' => env('DB_USERNAME', 'spaceflight_db_user'),
            'password' => env('DB_PASSWORD', 'spaceflight'),
            'options' => [
                'database' => env('DB_AUTHENTICATION_DATABASE', 'admin'),
            ],
        ],
    ],
];
