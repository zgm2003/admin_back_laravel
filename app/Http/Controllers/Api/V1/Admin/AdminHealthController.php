<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

final class AdminHealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return ApiResponse::success([
            'status' => 'ok',
            'client' => 'admin',
            'service' => config('app.name'),
            'api_version' => config('api.version'),
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
