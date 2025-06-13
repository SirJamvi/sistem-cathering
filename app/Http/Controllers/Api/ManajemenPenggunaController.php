<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DaftarKaryawanRequest; // <-- 1. Import Form Request
use App\Jobs\KirimEmailAkun; // <-- 2. Import Job
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManajemenPenggunaController extends Controller
{
    public function indexKaryawan(Request $request)
    {
        $karyawan = Karyawan::with(['divisi', 'shift'])->paginate($request->get('limit', 15));
        return response()->json($karyawan);
    }

    // 3. Ganti Request dengan DaftarKaryawanRequest
    public function storeKaryawan(DaftarKaryawanRequest $request)
    {
        // Blok validasi sudah tidak diperlukan lagi di sini
        $validatedData = $request->validated();
        $password = Str::random(8); // Password sementara

        $user = DB::transaction(function () use ($validatedData, $password) {
            $user = User::create([
                'name' => $validatedData['nama_lengkap'],
                'email' => $validatedData['email'],
                'password' => Hash::make($password)
            ]);
            $user->assignRole('karyawan');

            // Buat data karyawan dari data yang sudah tervalidasi
            $user->karyawan()->create($validatedData);
            
            return $user;
        });

        // 4. Panggil Job untuk mengirim email secara asynchronous
        KirimEmailAkun::dispatch($user, $password);
        
        return response()->json([
            'message' => 'Karyawan berhasil dibuat. Email berisi detail akun sedang dikirim.',
            'karyawan' => $user->load('karyawan'),
            // Sebaiknya password tidak dikirim di response API production
            // 'password_sementara' => $password 
        ], 201);
    }
}