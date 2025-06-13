<?php
// database/factories/LogScanQrFactory.php
namespace Database\Factories;

use App\Models\LogScanQr;
use App\Models\Karyawan;
use App\Models\Koki;
use App\Models\QrCodeDinamis;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LogScanQrFactory extends Factory
{
    protected $model = LogScanQr::class;

    public function definition(): array
    {
        $hasilScan = fake()->randomElement([
            'berhasil', 'gagal_expired', 'gagal_used', 
            'gagal_invalid', 'gagal_shift', 'gagal_double'
        ]);

        $pesanError = match($hasilScan) {
            'gagal_expired' => 'QR Code sudah expired',
            'gagal_used' => 'QR Code sudah digunakan',
            'gagal_invalid' => 'QR Code tidak valid',
            'gagal_shift' => 'Tidak sesuai dengan shift aktif',
            'gagal_double' => 'Sudah mengambil makanan hari ini',
            default => null
        };

        return [
            'karyawan_id' => Karyawan::factory(),
            'koki_id' => Koki::factory(),
            'qr_code_dinamis_id' => $hasilScan === 'berhasil' ? QrCodeDinamis::factory() : null,
            'qr_token_scanned' => Str::random(32),
            'waktu_scan' => fake()->dateTimeBetween('-7 days', 'now'),
            'hasil_scan' => $hasilScan,
            'pesan_error' => $pesanError,
            'detail_validasi' => json_encode([
                'shift_karyawan' => fake()->numberBetween(1, 3),
                'shift_aktif' => fake()->numberBetween(1, 3),
                'sudah_konsumsi' => fake()->boolean(),
                'qr_expired_at' => Carbon::instance(fake()->dateTime())->toISOString(),
                'scan_time' => now()->toISOString(),
            ]),
            'ip_scanner' => fake()->ipv4(),
            'device_info' => fake()->userAgent(),
        ];
    }

    public function berhasil(): static
    {
        return $this->state([
            'hasil_scan' => 'berhasil',
            'pesan_error' => null,
        ]);
    }

    public function gagal(): static
    {
        return $this->state([
            'hasil_scan' => fake()->randomElement([
                'gagal_expired', 'gagal_used', 'gagal_invalid', 'gagal_shift', 'gagal_double'
            ]),
        ]);
    }
}
