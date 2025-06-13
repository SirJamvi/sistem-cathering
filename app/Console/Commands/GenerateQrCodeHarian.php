<?php

namespace App\Console\Commands;

use App\Models\Karyawan;
use App\Models\QrCodeDinamis;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateQrCodeHarian extends Command
{
    /**
     * Nama dan signature dari console command.
     * {karyawan_id} : Argumen untuk memasukkan ID karyawan yang ingin diuji.
     */
    protected $signature = 'dev:test-generate-qr {karyawan_id : ID Karyawan yang akan dibuatkan QR code}';

    /**
     * Deskripsi dari console command.
     */
    protected $description = 'Testing: Membuat satu QR code untuk karyawan tertentu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $karyawanId = $this->argument('karyawan_id');
        $karyawan = Karyawan::find($karyawanId);

        if (!$karyawan) {
            $this->error("Karyawan dengan ID {$karyawanId} tidak ditemukan.");
            return 1; // Return non-zero untuk menandakan error
        }

        $this->info("Membuat QR code untuk: {$karyawan->nama_lengkap}...");

        $token = Str::random(60);
        $expirationTime = Carbon::now()->addSeconds(15);

        QrCodeDinamis::create([
            'karyawan_id' => $karyawan->id,
            'qr_token' => $token,
            'qr_hash' => hash('sha256', $token),
            'created_at_qr' => Carbon::now(),
            'expired_at' => $expirationTime,
        ]);

        $this->info("QR Code berhasil dibuat.");
        $this->line("Token: {$token}");

        return 0; // Return 0 untuk menandakan sukses
    }
}