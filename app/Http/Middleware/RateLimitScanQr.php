<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitScanQr
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'scan-qr.' . ($request->user()->id ?: $request->ip());

        // Batasi 10 permintaan per menit
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'message' => 'Terlalu banyak percobaan. Silakan coba lagi dalam ' . $seconds . ' detik.'
            ], 429); // 429 Too Many Requests
        }

        RateLimiter::hit($key);

        return $next($request);
    }
}