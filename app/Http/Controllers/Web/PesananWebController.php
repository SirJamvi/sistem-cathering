<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuatPesananRequest;
use App\Models\PesananMakanan;
use App\Models\Shift;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananWebController extends Controller
{
    // Menampilkan daftar semua pesanan
    public function index()
    {
        $pesanan = PesananMakanan::with(['vendor', 'shift'])->latest()->paginate(10);
        return view('hrga.pesanan.index', compact('pesanan'));
    }

    // Menampilkan form untuk membuat pesanan baru
    public function create()
    {
        $vendors = Vendor::where('status_kontrak', 'aktif')->get();
        $shifts = Shift::where('is_active', true)->get();
        return view('hrga.pesanan.create', compact('vendors', 'shifts'));
    }

    // Menyimpan pesanan baru
    public function store(BuatPesananRequest $request)
    {
        $validatedData = $request->validated();
        
        $vendor = Vendor::find($validatedData['vendor_id']);
        $adminHrga = Auth::user()->adminHrga;

        PesananMakanan::create([
            'admin_hrga_id' => $adminHrga->id,
            'vendor_id' => $validatedData['vendor_id'],
            'shift_id' => $validatedData['shift_id'],
            'tanggal_pesanan' => $validatedData['tanggal_pesanan'],
            'jumlah_porsi_dipesan' => $validatedData['jumlah_porsi_dipesan'],
            'total_harga' => $validatedData['jumlah_porsi_dipesan'] * $vendor->harga_per_porsi,
            'catatan_pesanan' => $validatedData['catatan_pesanan'] ?? null,
            'status_pesanan' => 'draft',
        ]);

        return redirect()->route('hrga.pesanan.index')->with('success', 'Pesanan makanan berhasil dibuat.');
    }

    // Menampilkan detail pesanan
    public function show(PesananMakanan $pesanan)
    {
        return view('hrga.pesanan.show', compact('pesanan'));
    }
}