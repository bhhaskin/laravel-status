<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

test('health endpoint returns 200 when all checks pass', function () {
    $response = $this->get('/health');

    $response->assertStatus(200);
    $response->assertJson([
        'status' => 'ok',
    ]);
    $response->assertJsonStructure([
        'status',
    ]);
});

test('health endpoint returns 503 when database check fails', function () {
    // Simulate database failure by using invalid connection
    config(['database.connections.testbench.database' => '/invalid/path/database.sqlite']);

    // Force reconnection
    DB::purge('testbench');

    $response = $this->get('/health');

    $response->assertStatus(503);
    $data = $response->json();
    expect($data['status'])->toBe('error');
});
