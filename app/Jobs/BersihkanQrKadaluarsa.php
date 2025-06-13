<?php

namespace App\Jobs;

use App\Models\QrCodeDinamis;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BersihkanQrKadaluarsa implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Hapus semua QR code yang dibuat lebih dari 24 jam yang lalu
        $cutoffDate = Carbon::now()->subDay();
        
        Log::info('Memulai proses pembersihan QR code kadaluarsa sebelum: ' . $cutoffDate->toDateTimeString());

        $deletedRows = QrCodeDinamis::where('created_at', '<', $cutoffDate)->delete();

        Log::info("Proses pembersihan selesai. {$deletedRows} baris data QR code dihapus.");
    }
}