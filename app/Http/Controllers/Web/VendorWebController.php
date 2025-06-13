<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorWebController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(10);
        return view('hrga.manajemen.vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('hrga.manajemen.vendor.create');
    }

    public function store(VendorRequest $request)
    {
        Vendor::create($request->validated());
        return redirect()->route('hrga.manajemen.vendor.index')->with('success', 'Vendor baru berhasil ditambahkan.');
    }

    public function show(Vendor $vendor)
    {
        return view('hrga.manajemen.vendor.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('hrga.manajemen.vendor.edit', compact('vendor'));
    }

    public function update(VendorRequest $request, Vendor $vendor)
    {
        $vendor->update($request->validated());
        return redirect()->route('hrga.manajemen.vendor.index')->with('success', 'Data vendor berhasil diperbarui.');
    }

    public function destroy(Vendor $vendor)
    {
        // Cek apakah vendor memiliki relasi
        if ($vendor->pesananMakanan()->exists() || $vendor->laporanBulanan()->exists()) {
            return back()->with('error', 'Gagal menghapus! Vendor ini memiliki riwayat pesanan atau laporan.');
        }

        $vendor->delete();
        return redirect()->route('hrga.manajemen.vendor.index')->with('success', 'Data vendor berhasil dihapus.');
    }
}