<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Mengambil daftar semua vendor yang aktif.
     */
    public function index(Request $request)
    {
        $vendors = Vendor::where('status_kontrak', 'aktif')
            ->orderBy('nama_vendor')
            ->get();

        return response()->json($vendors);
    }

    /**
     * Menampilkan detail satu vendor.
     */
    public function show(Vendor $vendor)
    {
        return response()->json($vendor);
    }
}