<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Status Check Enabled
    |--------------------------------------------------------------------------
    |
    | Enable or disable the status check endpoint.
    |
    */
    'enabled' => env('STATUS_CHECK_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Status Check Path
    |--------------------------------------------------------------------------
    |
    | The path for the status check endpoint.
    |
    */
    'path' => env('STATUS_CHECK_PATH', 'health'),

    /*
    |--------------------------------------------------------------------------
    | Status Check Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware to apply to the status check endpoint.
    |
    */
    'middleware' => [],

    /*
    |--------------------------------------------------------------------------
    | Health Checks
    |--------------------------------------------------------------------------
    |
    | Configure which health checks to run.
    |
    */
    'checks' => [
        'database' => env('STATUS_CHECK_DATABASE', true),
        'cache' => env('STATUS_CHECK_CACHE', true),
    ],
];
