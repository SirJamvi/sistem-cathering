<?php

namespace App\Http\Middleware;

use App\Models\QrCodeDinamis;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ValidasiQrCode
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $rawToken = $request->input('qr_token');
            Log::info('ValidasiQrCode triggered', [
                'qr_token_raw' => $rawToken,
            ]);

            if (! $rawToken) {
                Log::warning('Token kosong');
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter qr_token tidak ditemukan.'
                ], 400);
            }

            // Jika berupa URL, ekstrak path terakhir
            if (filter_var($rawToken, FILTER_VALIDATE_URL)) {
                $path  = parse_url($rawToken, PHP_URL_PATH);
                $token = trim(ltrim($path, '/'));
                Log::info('Ekstrak token dari URL', [
                    'extracted_token' => $token,
                ]);
            } else {
                $token = trim($rawToken);
            }

            // Query database
            $qr = QrCodeDinamis::with('karyawan')
                ->where('qr_token', $token)
                ->first();

            // Logging hasil query
            if ($qr) {
                Log::info('QR Code ditemukan di DB', [
                    'qr_id'       => $qr->id,
                    'is_used'     => $qr->is_used,
                    'expired_at'  => $qr->expired_at,
                    'karyawan_id' => $qr->karyawan_id,
                ]);
            } else {
                Log::warning('QR Code tidak ada di DB', [
                    'search_token' => $token,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid atau tidak ditemukan.'
                ], 404);
            }

            // Cek sudah dipakai?
            if ($qr->is_used) {
                Log::warning('QR Code sudah dipakai', [
                    'used_at' => $qr->used_at,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code sudah pernah digunakan pada ' .
                                 Carbon::parse($qr->used_at)->format('d/m/Y H:i:s')
                ], 409);
            }

            // Cek expired?
            if (Carbon::now()->greaterThan($qr->expired_at)) {
                Log::warning('QR Code expired', [
                    'expired_at' => $qr->expired_at,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code sudah kedaluwarsa pada ' .
                                 Carbon::parse($qr->expired_at)->format('d/m/Y H:i:s')
                ], 410);
            }

            // Lampirkan objek QR untuk controller
            $request->attributes->add(['qr_code_dinamis' => $qr]);
            Log::info('Middleware valid, lanjut ke controller', [
                'qr_id' => $qr->id,
            ]);

            return $next($request);

        } catch (\Throwable $e) {
            Log::error('Error ValidasiQrCode middleware', [
                'message' => $e->getMessage(),
                'stack'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem dalam validasi QR Code.'
            ], 500);
        }
    }
}
