<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KonfigurasiSistem;
use Illuminate\Support\Facades\DB;

class KonfigurasiSistemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('konfigurasi_sistems')->delete();

        // Contoh Konfigurasi sesuai SOP
        KonfigurasiSistem::create([
            'key' => 'qr_expiration_seconds',
            'value' => '15',
            'description' => 'Durasi validitas QR code dinamis dalam detik.' // <-- DIUBAH
        ]);
        
        KonfigurasiSistem::create([
            'key' => 'nama_perusahaan',
            'value' => 'PT Manufaktur Maju Jaya',
            'description' => 'Nama perusahaan yang akan ditampilkan di laporan.' // <-- DIUBAH
        ]);
    }
}