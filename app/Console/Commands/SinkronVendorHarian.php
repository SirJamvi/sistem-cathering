<?php

namespace App\Console\Commands;

use App\Jobs\SinkronisasiVendor;
use App\Models\Vendor;
use Illuminate\Console\Command;

class SinkronVendorHarian extends Command
{
    /**
     * Nama dan signature dari console command.
     */
    protected $signature = 'sistem:sinkron-vendor';

    /**
     * Deskripsi dari console command.
     */
    protected $description = 'Memicu job untuk sinkronisasi data dengan semua vendor aktif';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses sinkronisasi data vendor...');

        $vendors = Vendor::where('status_kontrak', 'aktif')->get();

        if ($vendors->isEmpty()) {
            $this->info('Tidak ada vendor aktif yang perlu disinkronisasi.');
            return 0;
        }

        $bar = $this->output->createProgressBar($vendors->count());
        $bar->start();

        foreach ($vendors as $vendor) {
            // Mengirim setiap vendor ke dalam antrian job-nya masing-masing
            SinkronisasiVendor::dispatch($vendor);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("{$vendors->count()} job sinkronisasi vendor telah ditambahkan ke antrian.");
    }
}