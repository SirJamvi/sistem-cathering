<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekRoleKaryawan
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->user()->hasRole('karyawan')) {
            return $next($request);
        }

        return response()->json(['message' => 'Akses ditolak. Hanya untuk Karyawan.'], 403);
    }
}