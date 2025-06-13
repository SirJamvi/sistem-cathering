<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekRoleHrga
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->user()->hasRole('hrga')) {
            return $next($request);
        }

        return response()->json(['message' => 'Akses ditolak. Memerlukan hak akses HRGA.'], 403);
    }
}