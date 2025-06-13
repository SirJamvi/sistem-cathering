<?php
// database/factories/VendorFactory.php
namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    protected $model = Vendor::class;

    public function definition(): array
    {
        return [
            'nama_vendor' => fake()->company() . ' Catering',
            'kontak_person' => fake()->name(),
            'email' => fake()->unique()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'alamat' => fake()->address(),
            'status_kontrak' => fake()->randomElement(['aktif', 'non_aktif', 'suspended']),
            'tanggal_kontrak_mulai' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'tanggal_kontrak_berakhir' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'harga_per_porsi' => fake()->randomFloat(2, 15000, 35000), // Rp 15.000 - 35.000
            'catatan' => fake()->optional(0.6)->paragraph(),
        ];
    }

    public function aktif(): static
    {
        return $this->state(['status_kontrak' => 'aktif']);
    }
}