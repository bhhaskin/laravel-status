# Laravel Status

[![Tests](https://github.com/bhhaskin/laravel-status/workflows/Tests/badge.svg)](https://github.com/bhhaskin/laravel-status/actions)

A simple Laravel package that provides a health check API endpoint for monitoring your application's status.

## Features

- Simple `/health` endpoint that returns JSON status
- Database connectivity check
- Cache connectivity check
- Returns HTTP 200 for healthy, 503 for unhealthy
- Configurable endpoint path and checks
- Auto-discovery for Laravel

## Installation

Install via Composer:

```bash
composer require bhhaskin/laravel-status
```

The package will automatically register itself via Laravel's package auto-discovery.

## Usage

Once installed, the package automatically registers a `/health` endpoint that returns:

**Healthy Response (200):**
```json
{
  "status": "ok"
}
```

**Unhealthy Response (503):**
```json
{
  "status": "error"
}
```

Simply make a GET request to `/health` to check your application's status.

## Configuration

Publish the configuration file (optional):

```bash
php artisan vendor:publish --tag=laravel-status-config
```

This creates `config/status.php` with the following options:

```php
return [
    // Enable or disable the status check endpoint
    'enabled' => env('STATUS_CHECK_ENABLED', true),

    // The path for the status check endpoint
    'path' => env('STATUS_CHECK_PATH', 'health'),

    // Middleware to apply to the status check endpoint
    'middleware' => [],

    // Configure which health checks to run
    'checks' => [
        'database' => env('STATUS_CHECK_DATABASE', true),
        'cache' => env('STATUS_CHECK_CACHE', true),
    ],
];
```

### Environment Variables

You can configure the package using environment variables:

```env
STATUS_CHECK_ENABLED=true
STATUS_CHECK_PATH=health
STATUS_CHECK_DATABASE=true
STATUS_CHECK_CACHE=true
```

## Testing

Run the test suite:

```bash
composer test
```

## Requirements

- PHP 8.1 or higher
- Laravel 10.x or 11.x

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).