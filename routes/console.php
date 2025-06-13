<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // <-- 1. Import Schedule Facade
use App\Jobs\GenerateLaporanHarian;      // <-- 2. Import Jobs
use App\Jobs\BersihkanQrKadaluarsa;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// --- TAMBAHKAN PENJADWALAN ANDA DI SINI ---
Schedule::job(new GenerateLaporanHarian(now()))
    ->dailyAt('23:00') // Jalankan setiap hari pukul 11 malam
    ->timezone('Asia/Jakarta');

Schedule::job(new BersihkanQrKadaluarsa)
    ->daily() // Jalankan setiap tengah malam
    ->timezone('Asia/Jakarta');