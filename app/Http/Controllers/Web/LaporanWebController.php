<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LaporanBulanan;
use App\Models\LaporanHarian;
use App\Models\Shift;
use App\Models\Vendor;
use Illuminate\Http\Request;

class LaporanWebController extends Controller
{
    /**
     * Menampilkan halaman laporan harian dengan filter.
     */
    public function harian(Request $request)
    {
        $laporan = LaporanHarian::query()
            ->when($request->filled('tanggal'), function ($q) use ($request) {
                $q->whereDate('tanggal', $request->tanggal);
            })
            ->when($request->filled('shift_id'), function ($q) use ($request) {
                $q->where('shift_id', $request->shift_id);
            })
            ->with(['shift', 'pesananMakanan.vendor'])
            ->latest()
            ->paginate(20);

        $shifts = Shift::where('is_active', true)->get();

        // Panggil view di folder hrga/laporan
        return view('hrga.laporan.harian', compact('laporan', 'shifts'));
    }

    /**
     * Menampilkan halaman laporan bulanan dengan filter.
     */
    public function bulanan(Request $request)
    {
        $laporan = LaporanBulanan::query()
            ->when($request->filled('bulan'), function ($q) use ($request) {
                $q->where('bulan', $request->bulan);
            })
            ->when($request->filled('tahun'), function ($q) use ($request) {
                $q->where('tahun', $request->tahun);
            })
            ->when($request->filled('vendor_id'), function ($q) use ($request) {
                $q->where('vendor_id', $request->vendor_id);
            })
            ->with('vendor')
            ->latest()
            ->paginate(12);
        
        $vendors = Vendor::where('status_kontrak', 'aktif')->get();

        // Panggil view di folder hrga/laporan
        return view('hrga.laporan.bulanan', compact('laporan', 'vendors'));
    }
}
