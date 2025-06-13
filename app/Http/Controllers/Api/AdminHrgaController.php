<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Vendor;
use App\Models\PesananMakanan;
use Illuminate\Support\Carbon;

class AdminHrgaController extends Controller
{
    public function dashboardSummary()
    {
        return response()->json([
            'total_karyawan_aktif' => Karyawan::where('status_kerja', 'aktif')->count(),
            'total_vendor_aktif' => Vendor::where('status_kontrak', 'aktif')->count(),
            'pesanan_hari_ini' => PesananMakanan::whereDate('tanggal_pesanan', Carbon::today())->count(),
        ]);
    }
}