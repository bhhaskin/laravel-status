<?php

namespace Bhhaskin\LaravelStatus\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function health(): JsonResponse
    {
        $status = 'ok';

        if (config('status.checks.database', true)) {
            $databaseCheck = $this->checkDatabase();
            if (!$databaseCheck['healthy']) {
                $status = 'error';
            }
        }

        if (config('status.checks.cache', true)) {
            $cacheCheck = $this->checkCache();
            if (!$cacheCheck['healthy']) {
                $status = 'error';
            }
        }

        $response = [
            'status' => $status,
        ];

        $statusCode = $status === 'ok' ? 200 : 503;

        return response()->json($response, $statusCode);
    }

    protected function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            return [
                'healthy' => true,
                'message' => 'Database connection successful',
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Database connection failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    protected function checkCache(): array
    {
        try {
            $key = 'laravel_status_health_check';
            $value = 'test';

            Cache::put($key, $value, 10);
            $retrieved = Cache::get($key);
            Cache::forget($key);

            if ($retrieved === $value) {
                return [
                    'healthy' => true,
                    'message' => 'Cache is working',
                ];
            }

            return [
                'healthy' => false,
                'message' => 'Cache read/write mismatch',
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Cache check failed',
                'error' => $e->getMessage(),
            ];
        }
    }
}
