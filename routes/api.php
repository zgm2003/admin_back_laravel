<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\HealthController;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\TraceRequest;
use Illuminate\Support\Facades\Route;

Route::middleware([
    TraceRequest::class,
    ForceJsonResponse::class,
])
    ->prefix('v1')
    ->name('api.v1.')
    ->group(function (): void {
        Route::get('/health', HealthController::class)->name('health');

        Route::prefix('admin')
            ->name('admin.')
            ->group(base_path('routes/api/admin.php'));

        Route::prefix('app')
            ->name('app.')
            ->group(base_path('routes/api/app.php'));
    });
