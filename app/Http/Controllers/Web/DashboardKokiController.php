<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DistribusiMakanan;
use App\Models\Karyawan;
use App\Models\LogScanQr;
use App\Models\PesananMakanan;
use App\Models\QrCodeDinamis;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini

class DashboardKokiController extends Controller
{
    // ... (method index() tetap sama) ...
    public function index()
    {
        $shiftAktif = $this->getShiftAktif();
        $pesanan = null;
        $sisaKaryawan = collect();
        $totalDipesan = 0;
        $totalDiambil = 0;

        if ($shiftAktif) {
            $pesanan = PesananMakanan::where('shift_id', $shiftAktif->id)
                ->whereDate('tanggal_pesanan', Carbon::today())
                ->first();

            if ($pesanan) {
                $totalDipesan = $pesanan->jumlah_porsi_dipesan;

                $karyawanSudahAmbilIds = DistribusiMakanan::where('pesanan_makanan_id', $pesanan->id)
                    ->pluck('karyawan_id');
                
                $totalDiambil = $karyawanSudahAmbilIds->count();

                $sisaKaryawan = Karyawan::where('shift_id', $shiftAktif->id)
                    ->where('status_kerja', 'aktif')
                    ->whereNotIn('id', $karyawanSudahAmbilIds)
                    ->get();
            }
        }
        
        return view('koki.dashboard', compact('shiftAktif', 'pesanan', 'sisaKaryawan', 'totalDipesan', 'totalDiambil'));
    }


    public function prosesScan(Request $request)
    {
        $request->validate(['qr_token' => 'required|string']);
        $qrToken = $request->input('qr_token');

        // --- BAGIAN YANG DIPERBAIKI ---
        $user = Auth::user();

        // Cek apakah pengguna login dan memiliki profil koki
        if (!$user || !$user->koki) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Profil Koki tidak ditemukan.'], 403);
        }
        $koki = $user->koki; // Ambil profil koki yang sudah divalidasi
        // --- AKHIR BAGIAN YANG DIPERBAIKI ---
        
        // 1. Cari QR Token di database
        $qr = QrCodeDinamis::where('qr_token', $qrToken)->first();

        // ... (sisa kode method prosesScan() tetap sama) ...
        if (!$qr) {
            return response()->json(['success' => false, 'message' => 'QR Code tidak valid.'], 404);
        }
        if (Carbon::now()->greaterThan($qr->expired_at)) {
             LogScanQr::create([/* Log data kegagalan */]);
            return response()->json(['success' => false, 'message' => 'QR Code sudah kedaluwarsa.'], 410);
        }
        if ($qr->is_used) {
            LogScanQr::create([/* Log data kegagalan */]);
            return response()->json(['success' => false, 'message' => 'QR Code sudah pernah digunakan.'], 409);
        }
        $karyawan = $qr->karyawan;
        $shiftAktif = $this->getShiftAktif();

        if (!$shiftAktif || $karyawan->shift_id != $shiftAktif->id) {
             LogScanQr::create([/* Log data kegagalan */]);
            return response()->json(['success' => false, 'message' => 'Shift karyawan tidak sesuai.'], 403);
        }
        $pesanan = PesananMakanan::where('shift_id', $shiftAktif->id)->whereDate('tanggal_pesanan', Carbon::today())->first();
        if (!$pesanan) {
            return response()->json(['success' => false, 'message' => 'Pesanan untuk shift ini tidak ditemukan.'], 404);
        }
        $sudahAmbil = DistribusiMakanan::where('pesanan_makanan_id', $pesanan->id)->where('karyawan_id', $karyawan->id)->exists();

        if ($sudahAmbil) {
            return response()->json(['success' => false, 'message' => 'Karyawan sudah mengambil jatah makan.'], 409);
        }
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
            LogScanQr::create([
                'karyawan_id' => $karyawan->id,
                'koki_id' => $koki->id,
                'qr_code_dinamis_id' => $qr->id,
                'qr_token_scanned' => $qr->qr_token,
                'waktu_scan' => Carbon::now(),
                'hasil_scan' => 'berhasil',
            ]);
        });

        return response()->json([
            'success' => true, 
            'message' => 'Validasi Berhasil',
            'karyawan' => ['nama' => $karyawan->nama_lengkap, 'divisi' => $karyawan->divisi->nama_divisi]
        ]);
    }

    // ... (method getShiftAktif() tetap sama) ...
    private function getShiftAktif()
    {
        $now = Carbon::now()->format('H:i:s');
        return Shift::where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    $q->where('jam_mulai', '<=', 'jam_selesai')
                      ->whereTime('jam_mulai', '<=', $now)
                      ->whereTime('jam_selesai', '>=', $now);
                })->orWhere(function ($q) use ($now) {
                    $q->where('jam_mulai', '>', 'jam_selesai')
                      ->where(function ($sub) use ($now) {
                          $sub->whereTime('jam_mulai', '<=', $now)
                              ->orWhereTime('jam_selesai', '>=', $now);
                      });
                });
            })
            ->first();
    }
}