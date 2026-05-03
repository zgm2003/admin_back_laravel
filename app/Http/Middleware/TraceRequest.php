<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class TraceRequest
{
    private const HEADER = 'X-Request-Id';

    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $traceId = $request->headers->get(self::HEADER) ?: (string) Str::uuid();
        $request->attributes->set('trace_id', $traceId);

        $response = $next($request);
        $response->headers->set(self::HEADER, $traceId);

        return $response;
    }
}
