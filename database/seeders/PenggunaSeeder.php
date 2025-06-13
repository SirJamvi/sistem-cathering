<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $divisiProduksi = Divisi::where('nama_divisi', 'Produksi')->first();
        $divisiGudang = Divisi::where('nama_divisi', 'Gudang')->first();

        // 1. Admin HRGA
        $hrga = User::create([
            'name' => 'Admin HRGA',
            'email' => 'hrga@example.com',
            'password' => Hash::make('password'),
        ]);
        $hrga->assignRole('hrga'); // Menetapkan role menggunakan Spatie

        // 2. Koki
        $koki = User::create([
            'name' => 'Koki Dapur',
            'email' => 'koki@example.com',
            'password' => Hash::make('password'),
        ]);
        $koki->assignRole('koki'); // Menetapkan role menggunakan Spatie

        // 3. Karyawan
        $karyawan1 = User::create([
            'name' => 'Budi Setiawan',
            'email' => 'budi.karyawan@example.com',
            // 'id_karyawan' => 'K001', // Kolom ini tidak ada di tabel 'users'
            'password' => Hash::make('password'),
            // 'divisi_id' => $divisiProduksi->id, // Kolom ini tidak ada di tabel 'users'
        ]);
        $karyawan1->assignRole('karyawan'); // Menetapkan role menggunakan Spatie

        $karyawan2 = User::create([
            'name' => 'Ani Suryani',
            'email' => 'ani.karyawan@example.com',
            // 'id_karyawan' => 'K002', // Kolom ini tidak ada di tabel 'users'
            'password' => Hash::make('password'),
            // 'divisi_id' => $divisiGudang->id, // Kolom ini tidak ada di tabel 'users'
        ]);
        $karyawan2->assignRole('karyawan'); // Menetapkan role menggunakan Spatie
    }
}