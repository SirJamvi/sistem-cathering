<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CegahScreenshot
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jalankan request untuk mendapatkan response
        $response = $next($request);

        // Tambahkan header khusus sebagai "sinyal" ke aplikasi mobile
        $response->headers->set('X-Prevent-Screenshot', 'true');

        return $response;
    }
}