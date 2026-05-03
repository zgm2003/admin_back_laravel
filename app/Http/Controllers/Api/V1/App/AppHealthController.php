<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\App;

use App\Http\Controllers\Controller;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

final class AppHealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return ApiResponse::success([
            'status' => 'ok',
            'client' => 'app',
            'service' => config('app.name'),
            'api_version' => config('api.version'),
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
