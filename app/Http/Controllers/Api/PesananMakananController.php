<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuatPesananRequest; // <-- 1. IMPORT FORM REQUEST
use App\Models\PesananMakanan;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananMakananController extends Controller
{
    public function index(Request $request)
    {
        $pesanan = PesananMakanan::with(['vendor', 'shift', 'adminHrga'])
            ->latest()
            ->paginate($request->get('limit', 15));
        return response()->json($pesanan);
    }

    // 2. GANTI Request DENGAN BuatPesananRequest
    public function store(BuatPesananRequest $request)
    {
        // 3. BLOK VALIDASI DI BAWAH INI SUDAH TIDAK DIPERLUKAN LAGI (DIHAPUS)
        /*
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'shift_id' => 'required|exists:shifts,id',
            'tanggal_pesanan' => 'required|date',
            'jumlah_porsi_dipesan' => 'required|integer|min:1',
            'catatan_pesanan' => 'nullable|string',
        ]);
        */

        // Ambil data yang sudah tervalidasi
        $validatedData = $request->validated();
        
        $vendor = Vendor::find($validatedData['vendor_id']);
        $adminHrga = Auth::user()->adminHrga;

        $pesanan = PesananMakanan::create([
            'admin_hrga_id' => $adminHrga->id,
            'vendor_id' => $validatedData['vendor_id'],
            'shift_id' => $validatedData['shift_id'],
            'tanggal_pesanan' => $validatedData['tanggal_pesanan'],
            'jumlah_porsi_dipesan' => $validatedData['jumlah_porsi_dipesan'],
            'total_harga' => $validatedData['jumlah_porsi_dipesan'] * $vendor->harga_per_porsi,
            'catatan_pesanan' => $validatedData['catatan_pesanan'] ?? null,
            'status_pesanan' => 'draft',
        ]);

        return response()->json($pesanan->load(['vendor', 'shift']), 201);
    }
}