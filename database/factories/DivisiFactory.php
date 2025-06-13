<?php
// database/factories/DivisiFactory.php
namespace Database\Factories;

use App\Models\Divisi;
use Illuminate\Database\Eloquent\Factories\Factory;

class DivisiFactory extends Factory
{
    protected $model = Divisi::class;

    public function definition(): array
    {
        $divisiNames = [
            'Produksi', 'Quality Control', 'Maintenance', 'HRGA', 'Finance', 
            'Purchasing', 'Warehouse', 'IT', 'Security', 'Engineering'
        ];

        $nama = fake()->randomElement($divisiNames);
        
        return [
            'nama_divisi' => $nama,
            'kode_divisi' => strtoupper(substr($nama, 0, 3)) . fake()->numerify('##'),
            'deskripsi' => fake()->optional(0.7)->sentence(10),
            'is_active' => fake()->boolean(95),
        ];
    }
}