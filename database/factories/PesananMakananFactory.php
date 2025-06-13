<?php
// database/factories/PesananMakananFactory.php
namespace Database\Factories;

use App\Models\PesananMakanan;
use App\Models\AdminHrga;
use App\Models\Vendor;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesananMakananFactory extends Factory
{
    protected $model = PesananMakanan::class;

    public function definition(): array
    {
        $jumlahPorsi = fake()->numberBetween(50, 200);
        $hargaPerPorsi = fake()->randomFloat(2, 20000, 30000);
        
        return [
            'admin_hrga_id' => AdminHrga::factory(),
            'vendor_id' => Vendor::factory(),
            'shift_id' => Shift::factory(),
            'tanggal_pesanan' => fake()->dateTimeBetween('-30 days', '+7 days')->format('Y-m-d'),
            'jumlah_porsi_dipesan' => $jumlahPorsi,
            'total_harga' => $jumlahPorsi * $hargaPerPorsi,
            'status_pesanan' => fake()->randomElement([
                'draft', 'dikirim_ke_vendor', 'dikonfirmasi_vendor', 
                'dalam_persiapan', 'dikirim', 'diterima', 'selesai'
            ]),
            'waktu_pengiriman_estimasi' => fake()->optional(0.8)->dateTimeBetween('now', '+2 days'),
            'catatan_pesanan' => fake()->optional(0.4)->sentence(),
            'menu_detail' => json_encode([
                'nasi_putih' => true,
                'lauk_utama' => fake()->randomElement(['ayam_goreng', 'ikan_bakar', 'daging_rendang']),
                'sayuran' => fake()->randomElement(['sayur_asem', 'tumis_kangkung', 'gado_gado']),
                'kerupuk' => true,
                'buah' => fake()->randomElement(['pisang', 'jeruk', 'apel'])
            ]),
        ];
    }

    public function hariIni(): static
    {
        return $this->state(['tanggal_pesanan' => today()->format('Y-m-d')]);
    }

    public function selesai(): static
    {
        return $this->state(['status_pesanan' => 'selesai']);
    }
}
