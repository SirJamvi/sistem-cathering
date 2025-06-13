<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DistribusiMakanan;
use App\Models\Karyawan;
use App\Models\PesananMakanan;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardHrgaController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk HRGA.
     */
    public function index()
    {
        $today = Carbon::today();

        // Statistik Utama
        $totalKaryawanAktif = Karyawan::where('status_kerja', 'aktif')->count();
        $totalVendorAktif = Vendor::where('status_kontrak', 'aktif')->count();

        // Statistik Pesanan & Konsumsi Hari Ini
        $pesananHariIni = PesananMakanan::whereDate('tanggal_pesanan', $today)->get();
        $totalPorsiDipesan = $pesananHariIni->sum('jumlah_porsi_dipesan');
        
        $pesananIds = $pesananHariIni->pluck('id');
        $totalPorsiDikonsumsi = DistribusiMakanan::whereIn('pesanan_makanan_id', $pesananIds)
                                                ->where('status_distribusi', 'berhasil')
                                                ->count();
        
        $sisaPorsi = $totalPorsiDipesan - $totalPorsiDikonsumsi;

        // Data untuk chart (contoh: konsumsi 7 hari terakhir)
        $konsumsiMingguan = DistribusiMakanan::selectRaw('DATE(waktu_pengambilan) as tanggal, count(*) as jumlah')
                                ->where('waktu_pengambilan', '>=', Carbon::now()->subDays(7))
                                ->groupBy('tanggal')
                                ->orderBy('tanggal', 'asc')
                                ->get();

        return view('hrga.dashboard', compact(
            'totalKaryawanAktif',
            'totalVendorAktif',
            'totalPorsiDipesan',
            'totalPorsiDikonsumsi',
            'sisaPorsi',
            'konsumsiMingguan'
        ));
    }
}