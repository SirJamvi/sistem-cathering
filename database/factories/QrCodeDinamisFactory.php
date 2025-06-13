<?php

namespace Database\Factories;

use App\Models\Karyawan;
use App\Models\QrCodeDinamis;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class QrCodeDinamisFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QrCodeDinamis::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $token = Str::random(40); // Membuat token acak

        return [
            'karyawan_id' => Karyawan::factory(), // Secara otomatis membuat & menghubungkan ke Karyawan
            'qr_token' => $token,
            'qr_hash' => Hash::make($token), // Hash token untuk validasi keamanan
            'created_at_qr' => now(),
            'expired_at' => now()->addSeconds(15), // Sesuai SOP, QR valid selama 15 detik
            'is_used' => false,
            'used_at' => null,
            'generated_ip' => fake()->ipv4(),
        ];
    }
}