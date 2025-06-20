<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PesananMakanan;
use App\Models\ValidasiFisik;
// Ganti Request dengan FormRequest yang sesuai
use App\Http\Requests\ValidasiFisikRequest; // <-- 1. IMPORT FORM REQUEST
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    /**
     * Mengambil daftar pesanan yang memerlukan validasi fisik.
     */
    public function listPesananUntukValidasi()
{
    $pesanan = PesananMakanan::whereDoesntHave('validasiFisik')
        // Ganti 'status' di Ionic dengan 'status_pesanan' yang ada di database
        ->whereIn('status_pesanan', ['dikirim']) 
        ->with(['vendor', 'shift']) // <-- Muat vendor DAN shift
        ->latest()
        ->get();
        
    // Transformasi data untuk menyamakan nama kolom
    $pesanan->transform(function ($item) {
        $item->status = $item->status_pesanan; 
        $item->jumlah_pesanan = $item->jumlah_porsi_dipesan;
        unset($item->status_pesanan);
        unset($item->jumlah_porsi_dipesan);
        if ($item->catatan_pesanan) {
            $item->menu = $item->catatan_pesanan;
            unset($item->catatan_pesanan);
        }
        return $item;
    });
        
    return response()->json($pesanan);
}
    
    /**
     * Menyimpan data hasil validasi fisik dari HRGA.
     */
    // 2. GANTI Request DENGAN ValidasiFisikRequest
    public function storeValidasiFisik(ValidasiFisikRequest $request)
    {
        // 3. BLOK VALIDASI INI SUDAH TIDAK DIPERLUKAN LAGI (DIHAPUS)
        /*
        $request->validate([
            'pesanan_makanan_id' => 'required|exists:pesanan_makanans,id',
            'jumlah_fisik_diterima' => 'required|integer|min:0',
            'jumlah_rusak' => 'required|integer|min:0',
            'catatan_validasi' => 'nullable|string',
        ]);
        */

        // Ambil data yang sudah lolos validasi dan otorisasi dari Form Request
        $validatedData = $request->validated();

        $adminHrga = Auth::user()->adminHrga;
        
        $pesanan = PesananMakanan::find($validatedData['pesanan_makanan_id']);
        if ($pesanan->validasiFisik) {
            return response()->json(['message' => 'Pesanan ini sudah pernah divalidasi.'], 409);
        }

        $jumlahKurang = $pesanan->jumlah_porsi_dipesan - $validatedData['jumlah_fisik_diterima'];

        $validasi = ValidasiFisik::create([
            'pesanan_makanan_id' => $pesanan->id,
            'admin_hrga_id' => $adminHrga->id,
            'jumlah_fisik_diterima' => $validatedData['jumlah_fisik_diterima'],
            'jumlah_kurang' => max(0, $jumlahKurang),
            'jumlah_rusak' => $validatedData['jumlah_rusak'],
            'catatan_validasi' => $validatedData['catatan_validasi'] ?? null,
            'waktu_validasi' => Carbon::now(),
            'status_validasi' => ($jumlahKurang <= 0 && $validatedData['jumlah_rusak'] == 0) ? 'sesuai' : 'ada_masalah'
        ]);

        // Update status pesanan menjadi 'diterima' atau 'selesai'
        $pesanan->update(['status_pesanan' => 'diterima']);

        return response()->json([
            'message' => 'Validasi fisik berhasil disimpan.',
            'data' => $validasi,
        ], 201);
    }
}