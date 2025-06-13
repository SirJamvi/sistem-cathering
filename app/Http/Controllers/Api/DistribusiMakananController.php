<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DistribusiMakanan;
use App\Models\LogScanQr;
use App\Models\PesananMakanan;
use App\Models\QrCodeDinamis;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DistribusiMakananController extends Controller
{
    /**
     * Memproses scan QR untuk distribusi makanan.
     */
    public function scanQr(Request $request)
    {
        $request->validate(['qr_token' => 'required|string']);
        
        $koki = Auth::user()->koki;
        if (!$koki) {
            return response()->json(['message' => 'Akses ditolak. Anda bukan Koki.'], 403);
        }

        $qr = QrCodeDinamis::where('qr_token', $request->qr_token)->first();

        // Validasi dasar
        if (!$qr || $qr->is_used || Carbon::now()->greaterThan($qr->expired_at)) {
            return response()->json(['message' => 'QR Code tidak valid, sudah digunakan, atau kedaluwarsa.'], 422);
        }

        $karyawan = $qr->karyawan;
        
        // Logika validasi lainnya (shift, sudah ambil, dll.)
        // (Sama seperti di DashboardKokiController)
        $pesanan = PesananMakanan::where('shift_id', $karyawan->shift_id)
            ->whereDate('tanggal_pesanan', Carbon::today())->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan untuk shift ini tidak ditemukan.'], 404);
        }
        
        $sudahAmbil = DistribusiMakanan::where('pesanan_makanan_id', $pesanan->id)->where('karyawan_id', $karyawan->id)->exists();
        if ($sudahAmbil) {
            return response()->json(['message' => 'Karyawan sudah mengambil jatah makan.'], 409);
        }

        // Proses transaksi jika semua validasi lolos
        try {
            DB::transaction(function () use ($qr, $karyawan, $koki, $pesanan) {
                $qr->update(['is_used' => true, 'used_at' => Carbon::now()]);
                DistribusiMakanan::create([
                    'pesanan_makanan_id' => $pesanan->id,
                    'karyawan_id' => $karyawan->id,
                    'koki_id' => $koki->id,
                    'qr_code_dinamis_id' => $qr->id,
                    'waktu_pengambilan' => Carbon::now(),
                    'status_distribusi' => 'berhasil',
                ]);
                LogScanQr::create([ 'karyawan_id' => $karyawan->id, 'koki_id' => $koki->id, /* ... data log lainnya ... */ 'hasil_scan' => 'berhasil']);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan internal.', 'error' => $e->getMessage()], 500);
        }

        return response()->json([
            'message' => 'Validasi Berhasil',
            'karyawan' => [ 'nama' => $karyawan->nama_lengkap, 'divisi' => $karyawan->divisi->nama_divisi ]
        ]);
    }
}