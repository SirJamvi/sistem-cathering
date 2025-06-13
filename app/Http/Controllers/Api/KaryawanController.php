<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StatusKonsumsi;

class KaryawanController extends Controller
{
    /**
     * Mengambil data profil karyawan yang sedang login.
     */
    public function profil()
    {
        $karyawan = Auth::user()->karyawan()->with(['divisi', 'shift'])->first();

        if (!$karyawan) {
            return response()->json(['message' => 'Profil karyawan tidak ditemukan.'], 404);
        }

        return response()->json($karyawan);
    }

    /**
     * Mengambil riwayat atau status konsumsi karyawan.
     */
    public function statusKonsumsi(Request $request)
    {
        $karyawan = Auth::user()->karyawan;

        if (!$karyawan) {
            return response()->json(['message' => 'Profil karyawan tidak ditemukan.'], 404);
        }
        
        $konsumsi = StatusKonsumsi::where('karyawan_id', $karyawan->id)
            ->latest()
            ->paginate($request->get('limit', 20));
            
        return response()->json($konsumsi);
    }
}