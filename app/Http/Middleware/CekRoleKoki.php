<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekRoleKoki
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->user()->hasRole('koki')) {
            return $next($request);
        }

        return response()->json(['message' => 'Akses ditolak. Hanya untuk Koki.'], 403);
    }
}