<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', function (): array {
    return [
        'data' => [
            'service' => config('app.name'),
            'type' => 'api',
            'api_version' => config('api.version'),
            'health' => url('/api/v1/health'),
        ],
    ];
});
