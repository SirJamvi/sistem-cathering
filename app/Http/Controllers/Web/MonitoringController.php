<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    /**
     * Tampilkan monitoring konsumsi harian
     */
    public function konsumsiHarian(Request $request)
    {
        $shifts  = Shift::where('is_active', true)->get();
        $divisi  = Divisi::where('is_active', true)->get();
        
        $karyawan = Karyawan::query()
            ->with([
                'divisi',
                'shift',
                'distribusiMakananHariIni'       // eager‑load relasi baru
            ])
            ->when($request->filled('shift_id'), function ($q) use ($request) {
                $q->where('shift_id', $request->shift_id);
            })
            ->when($request->filled('divisi_id'), function ($q) use ($request) {
                $q->where('divisi_id', $request->divisi_id);
            })
            ->where('status_kerja', 'aktif')
            ->orderBy('nama_lengkap')
            ->paginate(50)
            ->withQueryString();

        return view('hrga.monitoring.konsumsi', compact('shifts', 'divisi', 'karyawan'));
    }

    /**
     * Tampilkan halaman validasi fisik
     */
    public function validasiFisik(Request $request)
    {
        $pesananUntukValidasi = \App\Models\PesananMakanan::whereDoesntHave('validasiFisik')
            ->whereIn('status_pesanan', ['dikirim', 'diterima'])
            ->whereDate('tanggal_pesanan', Carbon::today())
            ->get();
            
        return view('hrga.monitoring.validasi_fisik', compact('pesananUntukValidasi'));
    }

    /**
     * Simpan hasil validasi fisik
     */
    public function storeValidasiFisik(Request $request)
    {
        $request->validate([
            'pesanan_makanan_id'      => 'required|exists:pesanan_makanans,id',
            'jumlah_fisik_diterima'   => 'required|integer|min:0',
            'jumlah_rusak'            => 'required|integer|min:0',
            'catatan_validasi'        => 'nullable|string',
        ]);

        $user = Auth::user();
        if (!$user || !$user->adminHrga) {
            return redirect()->back()->with('error', 'Akses ditolak. Profil HRGA tidak ditemukan.');
        }
        $adminHrgaId = $user->adminHrga->id;

        $pesanan      = \App\Models\PesananMakanan::findOrFail($request->pesanan_makanan_id);
        $jumlahKurang = $pesanan->jumlah_porsi_dipesan - $request->jumlah_fisik_diterima;

        \App\Models\ValidasiFisik::create([
            'pesanan_makanan_id'    => $pesanan->id,
            'admin_hrga_id'         => $adminHrgaId,
            'jumlah_fisik_diterima' => $request->jumlah_fisik_diterima,
            'jumlah_kurang'         => max(0, $jumlahKurang),
            'jumlah_rusak'          => $request->jumlah_rusak,
            'catatan_validasi'      => $request->catatan_validasi,
            'waktu_validasi'        => Carbon::now(),
            'status_validasi'       => ($jumlahKurang <= 0 && $request->jumlah_rusak == 0)
                                        ? 'sesuai'
                                        : 'ada_masalah',
        ]);

        return redirect()->back()->with('success', 'Validasi fisik berhasil disimpan.');
    }
}
