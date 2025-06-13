<?php
// database/factories/ShiftFactory.php
namespace Database\Factories;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftFactory extends Factory
{
    protected $model = Shift::class;

    public function definition(): array
    {
        $shifts = [
            ['nama' => 'Shift 1', 'mulai' => '07:00', 'selesai' => '15:00', 'makan_mulai' => '11:30', 'makan_selesai' => '12:30'],
            ['nama' => 'Shift 2', 'mulai' => '15:00', 'selesai' => '23:00', 'makan_mulai' => '19:00', 'makan_selesai' => '20:00'],
            ['nama' => 'Shift 3', 'mulai' => '23:00', 'selesai' => '07:00', 'makan_mulai' => '03:00', 'makan_selesai' => '04:00'],
        ];

        $shift = fake()->randomElement($shifts);

        return [
            'nama_shift' => $shift['nama'],
            'jam_mulai' => $shift['mulai'],
            'jam_selesai' => $shift['selesai'],
            'jam_makan_mulai' => $shift['makan_mulai'],
            'jam_makan_selesai' => $shift['makan_selesai'],
            'keterangan' => fake()->optional(0.5)->sentence(),
            'is_active' => true,
        ];
    }
}