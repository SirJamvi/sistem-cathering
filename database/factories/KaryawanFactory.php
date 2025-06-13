<?php
// database/factories/KaryawanFactory.php
namespace Database\Factories;

use App\Models\Karyawan;
use App\Models\Pengguna;
use App\Models\Divisi;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;

class KaryawanFactory extends Factory
{
    protected $model = Karyawan::class;

    public function definition(): array
    {
        return [
            'pengguna_id' => Pengguna::factory()->karyawan(),
            'divisi_id' => Divisi::factory(),
            'shift_id' => Shift::factory(),
            'nip' => fake()->unique()->numerify('NIP####'),
            'nama_lengkap' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional(0.8)->phoneNumber(),
            'status_kerja' => fake()->randomElement(['aktif', 'cuti', 'sakit', 'non_aktif']),
            'tanggal_bergabung' => fake()->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'berhak_konsumsi' => fake()->boolean(95), // 95% berhak konsumsi
        ];
    }

    public function aktif(): static
    {
        return $this->state([
            'status_kerja' => 'aktif',
            'berhak_konsumsi' => true,
        ]);
    }

    public function shift1(): static
    {
        return $this->state(['shift_id' => 1]);
    }

    public function shift2(): static
    {
        return $this->state(['shift_id' => 2]);
    }

    public function shift3(): static
    {
        return $this->state(['shift_id' => 3]);
    }
}