<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PesananMakanan;
use Illuminate\Support\Carbon;

class KaryawanController extends Controller
{
    /**
     * Mengambil data profil karyawan yang sedang login.
     */
    public function profil()
    {
        $karyawan = Auth::user()->karyawan()->with(['divisi', 'shift'])->first();

        if (!$karyawan) {
            return response()->json(['message' => 'Profil karyawan tidak ditemukan.'], 404);
        }

        return response()->json($karyawan);
    }

    /**
     * Mengambil seluruh riwayat konsumsi (untuk halaman riwayat).
     */
    public function statusKonsumsi(Request $request)
    {
        $karyawan = Auth::user()->karyawan;
        if (!$karyawan) {
            return response()->json(['message' => 'Profil karyawan tidak ditemukan.'], 404);
        }

        // Anda bisa tambahkan logika paginasi di sini jika perlu
        $history = $karyawan->distribusiMakanan()->with('pesananMakanan.shift')->latest('waktu_pengambilan')->paginate(20);

        return response()->json($history);
    }

    /**
     * ✱ METHOD BARU DAN EFISIEN UNTUK HALAMAN HOME ✱
     * Mengambil status konsumsi spesifik untuk hari ini.
     */
    public function statusKonsumsiHariIni()
    {
        $karyawan = Auth::user()->karyawan;

        // Cari di tabel distribusi makanan berdasarkan relasi yang sudah ada di model Karyawan
        $distribusi = $karyawan->distribusiMakananHariIni()->first();

        if ($distribusi) {
            return response()->json([
                'sudah_ambil' => true,
                'waktu_ambil' => $distribusi->waktu_pengambilan->toIso8601String(),
            ]);
        }

        return response()->json([
            'sudah_ambil' => false,
            'waktu_ambil' => null,
        ]);
    }

    /**
     * ✱ METHOD BARU DAN EFISIEN UNTUK HALAMAN HOME ✱
     * Mengambil detail menu makanan untuk shift karyawan hari ini.
     */
    public function menuHariIni()
    {
        $karyawan = Auth::user()->karyawan;

        if (!$karyawan || !$karyawan->shift) {
            return response()->json(['message' => 'Shift karyawan tidak ditemukan.'], 404);
        }

        $pesanan = PesananMakanan::where('shift_id', $karyawan->shift_id)
            ->whereDate('tanggal_pesanan', Carbon::today())
            ->first();

        if (!$pesanan || !$pesanan->menu_detail) {
            return response()->json([
                'menu' => null,
                'catatan' => 'Tidak ada jadwal atau menu makanan untuk shift Anda hari ini.'
            ], 200);
        }

        return response()->json([
            'menu' => $pesanan->menu_detail,
            'catatan' => $pesanan->catatan_pesanan,
        ]);
    }
}