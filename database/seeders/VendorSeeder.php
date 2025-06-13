<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendors')->delete();

        Vendor::create([
            'nama_vendor' => 'Catering Berkah Jaya',
            'kontak_person' => 'Bapak Subarjo',
            'phone' => '081234567890', // <-- DIUBAH DARI 'nomor_telepon'
            'alamat' => 'Jl. Industri Raya No. 123, Bekasi',
            // Kita juga perlu mengisi kolom yang wajib diisi dari migrasi
            'email' => 'berkahjaya@example.com',
            'status_kontrak' => 'aktif',
            'tanggal_kontrak_mulai' => now()->subMonths(6),
            'tanggal_kontrak_berakhir' => now()->addMonths(6),
            'harga_per_porsi' => 25000,
        ]);

        Vendor::create([
            'nama_vendor' => 'Dapur Sehat Sentosa',
            'kontak_person' => 'Ibu Wati',
            'phone' => '089876543210', // <-- DIUBAH DARI 'nomor_telepon'
            'alamat' => 'Jl. Pahlawan No. 45, Cikarang',
            // Kita juga perlu mengisi kolom yang wajib diisi dari migrasi
            'email' => 'dapursehat@example.com',
            'status_kontrak' => 'aktif',
            'tanggal_kontrak_mulai' => now()->subMonths(3),
            'tanggal_kontrak_berakhir' => now()->addMonths(9),
            'harga_per_porsi' => 27500,
        ]);
    }
}