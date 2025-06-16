<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DistribusiMakanan;
use App\Models\Karyawan;
use App\Models\LogScanQr;
use App\Models\PesananMakanan;
use App\Models\QrCodeDinamis;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DashboardKokiController extends Controller
{
    // Menampilkan profil koki
    public function showProfile(Request $request)
    {
        $koki = $request->user()->koki;
        return view('koki.profile', compact('koki'));
    }

    // Update profil koki
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $koki = $user->koki;

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'phone'        => 'nullable|string|max:20',
            'password'     => 'nullable|string|min:8|confirmed',
        ]);

        $koki->update($request->only('nama_lengkap', 'phone'));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // Halaman dashboard utama koki
    public function index(Request $request)
    {
        $user        = $request->user();
        $koki        = $user->koki;
        $shiftAktif  = $this->getShiftAktif();
        $pesanan     = null;
        $sisaKaryawan= collect();
        $totalDipesan= 0;
        $totalDiambil= 0;

        if ($shiftAktif) {
            $pesanan = PesananMakanan::where('shift_id', $shiftAktif->id)
                ->whereDate('tanggal_pesanan', Carbon::today())
                ->first();

            if ($pesanan) {
                $totalDipesan = $pesanan->jumlah_porsi_dipesan;

                $karyawanSudahAmbilIds = DistribusiMakanan::
                    where('pesanan_makanan_id', $pesanan->id)
                    ->pluck('karyawan_id');

                $totalDiambil   = $karyawanSudahAmbilIds->count();
                $sisaKaryawan  = Karyawan::where('shift_id', $shiftAktif->id)
                    ->where('status_kerja', 'aktif')
                    ->whereNotIn('id', $karyawanSudahAmbilIds)
                    ->with('divisi')
                    ->get();
            }
        }

        return view('koki.dashboard', compact(
            'koki',
            'shiftAktif',
            'pesanan',
            'sisaKaryawan',
            'totalDipesan',
            'totalDiambil'
        ));
    }

    // Proses scan QR Code otomatis (dengan debugging lengkap)
    public function prosesScan(Request $request)
{
    try {
        Log::info('Proses scan dimulai', [
            'qr_token' => $request->input('qr_token'),
            'user_id' => Auth::id(),
            'timestamp' => now()->toDateTimeString()
        ]);

        $request->validate([
            'qr_token' => 'required|string'
        ]);

        $qrToken = $request->input('qr_token');
        
        $qr = QrCodeDinamis::where('qr_token', $qrToken)
            ->with('karyawan.divisi')
            ->first();

        if (!$qr) {
            Log::warning('QR Code tidak ditemukan', ['qr_token' => $qrToken]);
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau tidak ditemukan.'
            ], 404);
        }

        if ($qr->is_used) {
            Log::warning('QR Code sudah digunakan', [
                'qr_token' => $qrToken,
                'used_at' => $qr->used_at
            ]);
            return response()->json([
                'success' => false,
                'message' => 'QR Code sudah pernah digunakan pada ' . Carbon::parse($qr->used_at)->format('d/m/Y H:i')
            ], 409);
        }

        if (Carbon::now()->greaterThan($qr->expired_at)) {
            Log::warning('QR Code kedaluwarsa', [
                'qr_token' => $qrToken,
                'expired_at' => $qr->expired_at
            ]);
            return response()->json([
                'success' => false,
                'message' => 'QR Code sudah kedaluwarsa pada ' . Carbon::parse($qr->expired_at)->format('d/m/Y H:i')
            ], 410);
        }

        $koki = Auth::user()->koki;
        $karyawan = $qr->karyawan;

        if (!$karyawan) {
            Log::error('Karyawan tidak ditemukan untuk QR', ['qr_id' => $qr->id]);
            return response()->json([
                'success' => false,
                'message' => 'Data karyawan tidak ditemukan.'
            ], 404);
        }

        $shiftAktif = $this->getShiftAktif();
        if (!$shiftAktif) {
            Log::warning('Tidak ada shift aktif');
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada shift yang aktif saat ini.'
            ], 403);
        }

        if ($karyawan->shift_id != $shiftAktif->id) {
            Log::warning('Shift tidak sesuai', [
                'karyawan_shift' => $karyawan->shift_id,
                'shift_aktif' => $shiftAktif->id,
                'karyawan' => $karyawan->nama_lengkap
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Shift karyawan tidak sesuai dengan shift aktif.'
            ], 403);
        }

        $pesanan = PesananMakanan::where('shift_id', $shiftAktif->id)
            ->whereDate('tanggal_pesanan', Carbon::today())
            ->first();

        if (!$pesanan) {
            Log::warning('Pesanan tidak ditemukan', [
                'shift_id' => $shiftAktif->id,
                'tanggal' => Carbon::today()->toDateString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Pesanan untuk shift ini tidak ditemukan hari ini.'
            ], 404);
        }

        $sudahAmbil = DistribusiMakanan::where('pesanan_makanan_id', $pesanan->id)
            ->where('karyawan_id', $karyawan->id)
            ->first();

        if ($sudahAmbil) {
            Log::warning('Karyawan sudah mengambil', [
                'karyawan' => $karyawan->nama_lengkap,
                'waktu_pengambilan' => $sudahAmbil->waktu_pengambilan
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Karyawan sudah mengambil jatah makan pada ' . 
                            Carbon::parse($sudahAmbil->waktu_pengambilan)->format('d/m/Y H:i')
            ], 409);
        }

        DB::beginTransaction();
        try {
            $qr->update([
                'is_used' => true, 
                'used_at' => Carbon::now()
            ]);

            $distribusi = DistribusiMakanan::create([
                'pesanan_makanan_id' => $pesanan->id,
                'karyawan_id'        => $karyawan->id,
                'koki_id'            => $koki->id,
                'qr_code_dinamis_id' => $qr->id,
                'waktu_pengambilan'  => Carbon::now(),
                'status_distribusi'  => 'berhasil',
            ]);

            // PERBAIKAN: Menambahkan qr_token_scanned yang sebelumnya missing
            LogScanQr::create([
    'karyawan_id'        => $karyawan->id,
    'koki_id'            => $koki->id,
    'qr_code_dinamis_id' => $qr->id,
    'qr_token_scanned'   => $qr->qr_token,
    'waktu_scan'         => Carbon::now(), // Pastikan ini diisi
    'hasil_scan'         => 'berhasil',
    'updated_at'         => Carbon::now(), // opsional
    'created_at'         => Carbon::now()  // opsional
]);

            DB::commit();

            Log::info('Scan berhasil', [
                'karyawan' => $karyawan->nama_lengkap,
                'koki' => $koki->nama_lengkap,
                'distribusi_id' => $distribusi->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Validasi Berhasil',
                'karyawan' => [
                    'id'     => $karyawan->id,
                    'nama'   => $karyawan->nama_lengkap,
                    'divisi' => $karyawan->divisi->nama_divisi ?? 'N/A',
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan distribusi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ], 500);
        }

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::warning('Validasi gagal', ['errors' => $e->errors()]);
        return response()->json([
            'success' => false,
            'message' => 'Data tidak valid: ' . implode(', ', $e->validator->errors()->all())
        ], 422);
        
    } catch (\Exception $e) {
        Log::error('Error tidak terduga dalam proses scan', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request' => $request->all()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
        ], 500);
    }
}

    // Test endpoint untuk debugging
    public function testQr(Request $request)
    {
        $qrToken = $request->get('token');
        
        if (!$qrToken) {
            return response()->json(['message' => 'Token required'], 400);
        }

        $qr = QrCodeDinamis::where('qr_token', $qrToken)
            ->with('karyawan.divisi', 'karyawan.shift')
            ->first();

        if (!$qr) {
            return response()->json(['message' => 'QR not found'], 404);
        }

        return response()->json([
            'qr_data' => [
                'id' => $qr->id,
                'qr_token' => $qr->qr_token,
                'is_used' => $qr->is_used,
                'used_at' => $qr->used_at,
                'expired_at' => $qr->expired_at,
                'is_expired' => Carbon::now()->greaterThan($qr->expired_at),
                'karyawan' => [
                    'id' => $qr->karyawan->id,
                    'nama' => $qr->karyawan->nama_lengkap,
                    'shift_id' => $qr->karyawan->shift_id,
                    'shift_nama' => $qr->karyawan->shift->nama_shift ?? 'N/A',
                    'divisi' => $qr->karyawan->divisi->nama_divisi ?? 'N/A'
                ]
            ],
            'shift_aktif' => $this->getShiftAktif(),
            'current_time' => Carbon::now()->toDateTimeString()
        ]);
    }

    // Menampilkan form validasi manual
    public function showManualForm()
    {
        return view('koki.validasi.manual');
    }

    // Proses validasi manual
    public function prosesManual(Request $request)
    {
        $request->validate([ 'karyawan_id' => 'required|exists:karyawans,id' ]);

        $user      = $request->user();
        $koki      = $user->koki;
        $karyawan  = Karyawan::findOrFail($request->karyawan_id);
        $shiftAktif= $this->getShiftAktif();

        if (!$shiftAktif || $karyawan->shift_id !== $shiftAktif->id) {
            return back()->with('error', 'Validasi gagal! Shift karyawan tidak sesuai.');
        }

        $pesanan = PesananMakanan::where('shift_id', $shiftAktif->id)
            ->whereDate('tanggal_pesanan', now())
            ->first();

        if (!$pesanan) {
            return back()->with('error', 'Validasi gagal! Tidak ada pesanan untuk shift ini.');
        }

        $sudahAmbil = DistribusiMakanan::where(
            'pesanan_makanan_id', $pesanan->id
        )->where('karyawan_id', $karyawan->id)
         ->exists();

        if ($sudahAmbil) {
            return back()->with('error', 'Validasi gagal! Karyawan sudah mengambil jatah makan.');
        }

        DistribusiMakanan::create([
            'pesanan_makanan_id' => $pesanan->id,
            'karyawan_id'        => $karyawan->id,
            'koki_id'            => $koki->id,
            'waktu_pengambilan'  => now(),
            'status_distribusi'  => 'berhasil',
            'catatan'            => 'Validasi Manual',
        ]);

        return back()->with('success', "Validasi untuk {$karyawan->nama_lengkap} berhasil.");
    }

    // Laporan harian koki
    public function laporanHarian(Request $request)
    {
        $shifts = Shift::where('is_active', true)
            ->orderBy('nama_shift')
            ->get();

        $user = $request->user();
        $scanQuery = LogScanQr::where('koki_id', $user->koki->id)
            ->whereDate('waktu_scan', today())
            ->with(['karyawan.shift']);

        if ($request->filled('shift_id')) {
            $scanQuery->whereHas('karyawan', function ($q) use ($request) {
                $q->where('shift_id', $request->shift_id);
            });
        }

        $scanHistory = $scanQuery->latest('waktu_scan')->paginate(20);

        return view('koki.laporan.harian', compact('scanHistory', 'shifts'));
    }

    // Mendapatkan shift aktif saat ini
    private function getShiftAktif()
    {
        $now = Carbon::now()->format('H:i:s');

        return Shift::where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    $q->whereTime('jam_mulai', '<=', $now)
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