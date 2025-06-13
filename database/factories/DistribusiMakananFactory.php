<?php
// database/factories/DistribusiMakananFactory.php
namespace Database\Factories;

use App\Models\DistribusiMakanan;
use App\Models\PesananMakanan;
use App\Models\Karyawan;
use App\Models\Koki;
use App\Models\QrCodeDinamis;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistribusiMakananFactory extends Factory
{
    protected $model = DistribusiMakanan::class;

    public function definition(): array
    {
        return [
            'pesanan_makanan_id' => PesananMakanan::factory(),
            'karyawan_id' => Karyawan::factory(),
            'koki_id' => Koki::factory(),
            'qr_code_dinamis_id' => QrCodeDinamis::factory(),
            'waktu_pengambilan' => fake()->dateTimeBetween('-7 days', 'now'),
            'status_distribusi' => fake()->randomElement(['berhasil', 'gagal', 'dikembalikan']),
            'catatan' => fake()->optional(0.3)->sentence(),
            'detail_validasi' => json_encode([
                'qr_valid' => true,
                'shift_sesuai' => true,
                'belum_ambil' => true,
                'waktu_validasi' => now()->toISOString(),
                'ip_address' => fake()->ipv4(),
            ]),
        ];
    }

    public function berhasil(): static
    {
        return $this->state([
            'status_distribusi' => 'berhasil',
            'detail_validasi' => json_encode([
                'qr_valid' => true,
                'shift_sesuai' => true,
                'belum_ambil' => true,
                'waktu_validasi' => now()->toISOString(),
                'ip_address' => fake()->ipv4(),
            ])
        ]);
    }
}