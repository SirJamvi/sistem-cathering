<?php

namespace App\Console\Commands;

use App\Models\LogScanQr;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

class BersihkanDataLama extends Command
{
    /**
     * Nama dan signature dari console command.
     * --days=180 : Opsi untuk menentukan data yang lebih tua dari berapa hari yang akan dihapus. Default 180 hari (6 bulan).
     */
    protected $signature = 'sistem:bersihkan-data-lama {--days=180 : Hapus data yang lebih tua dari (jumlah hari)}';

    /**
     * Deskripsi dari console command.
     */
    protected $description = 'Membersihkan data log lama (log scan qr, activity log) dari database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Memulai proses pembersihan data yang lebih tua dari {$days} hari (sebelum tanggal {$cutoffDate->toDateString()})...");
        Log::info("Memulai proses pembersihan data lama...");

        // Membersihkan Log Scan QR
        $deletedScanLogs = LogScanQr::where('created_at', '<', $cutoffDate)->delete();
        $this->info("{$deletedScanLogs} baris data Log Scan QR telah dihapus.");
        
        // Membersihkan Activity Log dari Spatie
        $deletedActivityLogs = Activity::where('created_at', '<', $cutoffDate)->delete();
        $this->info("{$deletedActivityLogs} baris data Activity Log telah dihapus.");

        Log::info("Pembersihan data lama selesai.");
        $this->info('Proses pembersihan selesai.');
    }
}