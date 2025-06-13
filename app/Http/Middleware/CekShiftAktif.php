<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CekShiftAktif
{
    public function handle(Request $request, Closure $next): Response
    {
        $karyawan = Auth::user()->karyawan;
        
        if (!$karyawan || !$karyawan->shift) {
            return response()->json(['message' => 'Profil shift karyawan tidak ditemukan.'], 404);
        }

        $shift = $karyawan->shift;
        $now = Carbon::now();

        // Cek apakah waktu sekarang berada di antara jam makan
        $isMealTime = $now->between(
            Carbon::parse($shift->jam_makan_mulai),
            Carbon::parse($shift->jam_makan_selesai)
        );

        if (!$isMealTime) {
            return response()->json(['message' => 'Akses ditolak. Belum waktunya jam makan untuk shift Anda.'], 403);
        }

        return $next($request);
    }
}