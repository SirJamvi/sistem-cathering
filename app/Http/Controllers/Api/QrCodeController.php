<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QrCodeDinamis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class QrCodeController extends Controller
{
    /**
     * Membuat dan mengembalikan QR Code dinamis untuk Karyawan.
     */
    public function generate(Request $request)
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (! $karyawan) {
            return response()->json([
                'message' => 'Profil karyawan tidak ditemukan.'
            ], 404);
        }
        
        // 1. Validasi hak konsumsi
        if (! $karyawan->berhak_konsumsi || $karyawan->status_kerja !== 'aktif') {
            return response()->json([
                'message' => 'Anda tidak berhak mendapatkan jatah makan saat ini.'
            ], 403);
        }

        // 2. Cek pesanan hari ini
        $pesanan = \App\Models\PesananMakanan::where('shift_id', $karyawan->shift_id)
            ->whereDate('tanggal_pesanan', Carbon::today())
            ->first();

        if (! $pesanan) {
            return response()->json([
                'message' => 'Tidak ada pesanan makanan untuk shift Anda hari ini.'
            ], 404);
        }

        // 3. Cek sudah diambil atau belum
        $sudahAmbil = \App\Models\DistribusiMakanan::where('pesanan_makanan_id', $pesanan->id)
            ->where('karyawan_id', $karyawan->id)
            ->exists();

        if ($sudahAmbil) {
            return response()->json([
                'message' => 'Jatah makan hari ini sudah diambil.'
            ], 409);
        }

        // 4. Expire QR lama (pastikan hanya satu QR aktif)
        QrCodeDinamis::where('karyawan_id', $karyawan->id)
            ->where('is_used', false)
            ->where('expired_at', '>', Carbon::now())
            ->update([
                'expired_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        // 5. Generate token & waktu expired (15 detik)
        $token = Str::random(60);
        $expirationTime = Carbon::now()->addSeconds(15);

        // 6. Simpan QR baru
        $qr = QrCodeDinamis::create([
            'karyawan_id'   => $karyawan->id,
            'qr_token'      => $token,
            'qr_hash'       => hash('sha256', $token),
            'created_at_qr' => Carbon::now(),
            'expired_at'    => $expirationTime,
            'is_used'       => false,
            'generated_ip'  => $request->ip(),
        ]);

        // 7. Kembalikan response
        return response()->json([
            'qr_token'   => $qr->qr_token,
            'expired_at' => $qr->expired_at->toIso8601String(),
        ], 201);
    }
}
