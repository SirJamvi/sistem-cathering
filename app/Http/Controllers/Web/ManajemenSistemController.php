<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\DaftarKaryawanRequest;
use App\Http\Requests\EditKaryawanRequest;
use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ManajemenSistemController extends Controller
{
    /**
     * Menampilkan daftar semua karyawan.
     */
    public function index()
    {
        $karyawan = Karyawan::with(['divisi', 'shift'])
            ->latest()
            ->paginate(15);

        return view('hrga.manajemen.karyawan.index', compact('karyawan'));
    }

    /**
     * Menampilkan form untuk membuat karyawan baru.
     */
    public function create()
    {
        $divisi = Divisi::where('is_active', true)->get();
        $shifts = Shift::where('is_active', true)->get();

        return view('hrga.manajemen.karyawan.create', compact('divisi', 'shifts'));
    }

    /**
     * Menyimpan data karyawan baru ke database.
     */
    public function store(DaftarKaryawanRequest $request)
    {
        // Tambahkan logging di awal proses
        Log::info('[WEB] Memulai proses pembuatan karyawan baru.');

        $validatedData = $request->validated();

        $user = DB::transaction(function () use ($validatedData) {
            $user = \App\Models\User::create([
                'name'     => $validatedData['nama_lengkap'],
                'email'    => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
            $user->assignRole('karyawan');

            $user->karyawan()->create($validatedData);

            // Logging setelah simpan user & profil karyawan
            Log::info('[WEB] User dan profil karyawan berhasil disimpan ke database.', [
                'user_id' => $user->id,
                'email'   => $user->email,
            ]);

            return $user;
        });

        return redirect()
            ->route('hrga.manajemen.karyawan.index')
            ->with('success', 'Karyawan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu karyawan.
     */
    public function show(Karyawan $karyawan)
    {
        return view('hrga.manajemen.karyawan.show', compact('karyawan'));
    }

    /**
     * Menampilkan form untuk mengedit karyawan.
     */
    public function edit(Karyawan $karyawan)
    {
        $divisi = Divisi::where('is_active', true)->get();
        $shifts = Shift::where('is_active', true)->get();

        return view('hrga.manajemen.karyawan.edit', compact('karyawan', 'divisi', 'shifts'));
    }

    /**
     * Memperbarui data karyawan di database.
     */
    public function update(EditKaryawanRequest $request, Karyawan $karyawan)
    {
        $validatedData = $request->validated();

        DB::transaction(function () use ($validatedData, $karyawan) {
            $karyawan->user->update([
                'name'  => $validatedData['nama_lengkap'],
                'email' => $validatedData['email'],
            ]);
            $karyawan->update($validatedData);
        });

        return redirect()
            ->route('hrga.manajemen.karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus data karyawan dari database.
     */
    public function destroy(Karyawan $karyawan)
    {
        try {
            // Foreign key di database sudah diatur 'ON DELETE CASCADE',
            // jadi saat user dihapus, data karyawan juga akan terhapus.
            $karyawan->user->delete();

            return redirect()
                ->route('hrga.manajemen.karyawan.index')
                ->with('success', 'Data karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menghapus data karyawan. Error: ' . $e->getMessage());
        }
    }
}
