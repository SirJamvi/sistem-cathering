<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManajemenSistemController extends Controller
{
    // --- MANAJEMEN KARYAWAN ---

    /**
     * Menampilkan daftar semua karyawan.
     */
    public function indexKaryawan()
    {
        $karyawan = Karyawan::with(['user', 'divisi', 'shift'])->paginate(15);
        return view('hrga.manajemen.karyawan.index', compact('karyawan'));
    }

    /**
     * Menampilkan form untuk membuat karyawan baru.
     */
    public function createKaryawan()
    {
        $divisi = Divisi::where('is_active', true)->get();
        $shifts = Shift::where('is_active', true)->get();
        return view('hrga.manajemen.karyawan.create', compact('divisi', 'shifts'));
    }

    /**
     * Menyimpan data karyawan baru ke database.
     */
    public function storeKaryawan(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'nip' => 'required|string|max:255|unique:karyawans,nip',
            'divisi_id' => 'required|exists:divisis,id',
            'shift_id' => 'required|exists:shifts,id',
            'tanggal_bergabung' => 'required|date',
            'phone' => 'nullable|string'
        ]);

        $password = Str::random(8);

        DB::transaction(function () use ($request, $password) {
            // 1. Buat data user
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($password)
            ]);

            // 2. Berikan role 'karyawan'
            $user->assignRole('karyawan');

            // 3. Buat data karyawan
            Karyawan::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'nip' => $request->nip,
                'divisi_id' => $request->divisi_id,
                'shift_id' => $request->shift_id,
                'tanggal_bergabung' => $request->tanggal_bergabung,
                'phone' => $request->phone,
                'status_kerja' => 'aktif',
                'berhak_konsumsi' => true
            ]);

            // Di sini Anda bisa menambahkan job untuk mengirim email berisi password ke user 
            // dispatch(new \App\Jobs\SendUserCredentialsJob($user, $password));
        });

        return redirect()->route('hrga.manajemen.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }
    
    // Method edit, update, dan destroy untuk karyawan bisa ditambahkan di sini
    // dengan logika yang serupa.

    // --- Method untuk manajemen VENDOR, SHIFT, dan DIVISI bisa ditambahkan di bawah ---
}