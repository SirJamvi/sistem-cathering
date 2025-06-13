<?php

namespace App\Http\Middleware;

use App\Models\QrCodeDinamis;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidasiQrCode
{
    public function handle(Request $request, Closure $next): Response
    {
        $qrToken = $request->input('qr_token');

        if (!$qrToken) {
            return response()->json(['message' => 'Parameter qr_token tidak ditemukan.'], 400);
        }

        $qr = QrCodeDinamis::where('qr_token', $qrToken)->first();

        if (!$qr) {
            return response()->json(['message' => 'QR Code tidak valid.'], 404);
        }

        if ($qr->is_used) {
            return response()->json(['message' => 'QR Code sudah pernah digunakan.'], 409); // 409 Conflict
        }

        if (Carbon::now()->greaterThan($qr->expired_at)) {
            return response()->json(['message' => 'QR Code sudah kedaluwarsa.'], 410); // 410 Gone
        }
        
        // Lampirkan objek QR yang valid ke request agar bisa dipakai di controller
        $request->attributes->add(['qr_code_dinamis' => $qr]);

        return $next($request);
    }
}