<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DaftarKaryawanRequest; // <-- 1. Import Form Request
use App\Jobs\KirimEmailAkun;               // <-- 2. Import Job
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;         // <-- 3. Import Log
use Illuminate\Support\Str;

class ManajemenPenggunaController extends Controller
{
    public function indexKaryawan(Request $request)
    {
        $karyawan = Karyawan::with(['divisi', 'shift'])
            ->paginate($request->get('limit', 15));

        return response()->json($karyawan);
    }

    // 4. Ganti Request dengan DaftarKaryawanRequest
    public function storeKaryawan(DaftarKaryawanRequest $request)
    {
        // Tambahkan logging di awal proses
        Log::info('[API] Memulai proses pembuatan karyawan baru.');

        $validatedData = $request->validated();
        $password = Str::random(8); // Password sementara

        $user = DB::transaction(function () use ($validatedData, $password) {
            $user = User::create([
                'name'     => $validatedData['nama_lengkap'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($password),
            ]);
            $user->assignRole('karyawan');

            // Buat data karyawan dari data yang sudah tervalidasi
            $user->karyawan()->create($validatedData);

            // Logging setelah simpan user & profil karyawan
            Log::info('[API] User dan profil karyawan berhasil disimpan ke database.', [
                'user_id' => $user->id,
                'email'   => $user->email,
            ]);

            return $user;
        });

        // Logging sebelum dispatch job
        Log::info('[API] Memicu job KirimEmailAkun untuk user ID ' . $user->id);

        // Panggil Job untuk mengirim email secara asynchronous
        KirimEmailAkun::dispatch($user, $password);

        return response()->json([
            'message'   => 'Karyawan berhasil dibuat. Email berisi detail akun sedang dikirim.',
            'karyawan'  => $user->load('karyawan'),
        ], 201);
    }
}
