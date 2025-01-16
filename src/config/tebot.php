<?php

return [
    'timezone' => env('APP_TIMEZONE', 'UTC'),
    'default'  => [
        'name'  => env('TEBOT_NAME', 'TEBOT'),
        'url'   => env('TEBOT_URL', 'localhost'),
        'key'   => env('TEBOT_KEY', null),
    ],
];
