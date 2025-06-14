<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\GenerateLaporanHarian;
use App\Jobs\BersihkanQrKadaluarsa;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// --- PENJADWALAN SISTEM CATERING ---

// 1. Generate QR Code Dinamis Setiap 15 Detik (KRITIS!)
Schedule::command('qr:generate-dinamis')
    ->everyFifteenSeconds()
    ->timezone('Asia/Jakarta')
    ->withoutOverlapping() // Prevent multiple instances
    ->runInBackground();   // Non-blocking

// 2. Generate Laporan Harian
Schedule::job(new GenerateLaporanHarian(now()))
    ->dailyAt('23:00')
    ->timezone('Asia/Jakarta');

// 3. Bersihkan QR Code Kadaluarsa (Setiap 5 Menit)
Schedule::job(new BersihkanQrKadaluarsa)
    ->everyFiveMinutes()
    ->timezone('Asia/Jakarta');

// 4. Cleanup QR Code Lama (Setiap Jam)
Schedule::command('qr:cleanup-expired')
    ->hourly()
    ->timezone('Asia/Jakarta');