<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaporanHarian;
use App\Models\LaporanBulanan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function harian(Request $request)
    {
        $laporan = LaporanHarian::query()
            ->when($request->filled('tanggal'), fn($q) => $q->whereDate('tanggal', $request->tanggal))
            ->with(['shift', 'pesananMakanan.vendor'])
            ->latest()
            ->paginate(20);

        return response()->json($laporan);
    }
    
    public function bulanan(Request $request)
    {
        $laporan = LaporanBulanan::query()
            ->when($request->filled('bulan'), fn($q) => $q->where('bulan', $request->bulan))
            ->when($request->filled('tahun'), fn($q) => $q->where('tahun', $request->tahun))
            ->with('vendor')
            ->latest()
            ->paginate(12);
            
        return response()->json($laporan);
    }
}