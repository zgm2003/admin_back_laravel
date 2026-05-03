<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

final class HealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return ApiResponse::success([
            'status' => 'ok',
            'service' => config('app.name'),
            'api_version' => config('api.version'),
            'environment' => app()->environment(),
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
