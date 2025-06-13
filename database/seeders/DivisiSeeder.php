<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Divisi;
use Illuminate\Support\Facades\DB;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('divisis')->delete(); // Kosongkan tabel terlebih dahulu

        // Tambahkan juga 'kode_divisi' agar sesuai dengan migrasi
        Divisi::create(['nama_divisi' => 'Produksi', 'kode_divisi' => 'PROD01']);
        Divisi::create(['nama_divisi' => 'Gudang', 'kode_divisi' => 'GUD01']);
        Divisi::create(['nama_divisi' => 'Maintenance', 'kode_divisi' => 'MAIN01']);
        Divisi::create(['nama_divisi' => 'Quality Control', 'kode_divisi' => 'QC01']);
        Divisi::create(['nama_divisi' => 'HRGA', 'kode_divisi' => 'HRGA01']);
    }
}