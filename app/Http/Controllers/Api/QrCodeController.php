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
    public function generate()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return response()->json(['message' => 'Profil karyawan tidak ditemukan.'], 404);
        }
        
        // Validasi apakah karyawan berhak dapat makan
        if (!$karyawan->berhak_konsumsi || $karyawan->status_kerja != 'aktif') {
            return response()->json(['message' => 'Anda tidak berhak mendapatkan jatah makan saat ini.'], 403);
        }

        // Validasi apakah karyawan sudah ambil makan hari ini untuk shift-nya
        $pesanan = \App\Models\PesananMakanan::where('shift_id', $karyawan->shift_id)
            ->whereDate('tanggal_pesanan', Carbon::today())->first();

        if ($pesanan) {
            $sudahAmbil = \App\Models\DistribusiMakanan::where('pesanan_makanan_id', $pesanan->id)
                ->where('karyawan_id', $karyawan->id)->exists();
            if ($sudahAmbil) {
                return response()->json(['message' => 'Jatah makan hari ini sudah diambil.'], 409);
            }
        } else {
             return response()->json(['message' => 'Tidak ada pesanan makanan untuk shift Anda hari ini.'], 404);
        }

        // Buat token baru
        $token = Str::random(60);
        $expirationTime = Carbon::now()->addSeconds(15); // QR valid selama 15 detik

        $qr = QrCodeDinamis::create([
            'karyawan_id' => $karyawan->id,
            'qr_token' => $token,
            'qr_hash' => hash('sha256', $token),
            'created_at_qr' => Carbon::now(),
            'expired_at' => $expirationTime,
            'generated_ip' => request()->ip(),
        ]);

        return response()->json([
            'qr_token' => $qr->qr_token,
            'expired_at' => $qr->expired_at->toIso8601String(),
        ]);
    }
}