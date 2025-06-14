<?php

namespace App\Console\Commands;

use App\Jobs\GenerateQrCodeDinamis;
use App\Models\Karyawan;
use App\Models\PesananMakanan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateQrCodeHarian extends Command
{
    /**
     * Nama dan signature dari console command.
     */
    protected $signature = 'qr:generate-dinamis 
                            {--karyawan_id= : ID Karyawan spesifik (opsional)}
                            {--force : Force generate meskipun sudah ada QR aktif}';

    /**
     * Deskripsi dari console command.
     */
    protected $description = 'Generate QR Code dinamis untuk karyawan yang memenuhi syarat setiap 15 detik';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Memulai proses generate QR Code dinamis...');
        
        $karyawanId = $this->option('karyawan_id');
        $forceGenerate = $this->option('force');

        try {
            if ($karyawanId) {
                // Generate untuk karyawan spesifik
                $this->generateForSpecificEmployee($karyawanId, $forceGenerate);
            } else {
                // Generate untuk semua karyawan yang memenuhi syarat
                $this->generateForAllEligibleEmployees($forceGenerate);
            }

            $this->info('✅ Proses generate QR Code selesai!');
            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            Log::error('GenerateQrCodeHarian command failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    /**
     * Generate QR untuk karyawan spesifik
     */
    private function generateForSpecificEmployee($karyawanId, $forceGenerate = false)
    {
        $karyawan = Karyawan::find($karyawanId);
        
        if (!$karyawan) {
            $this->error("❌ Karyawan dengan ID {$karyawanId} tidak ditemukan.");
            return;
        }

        $this->line("👤 Processing: {$karyawan->nama_lengkap}");

        // Dispatch job untuk generate QR
        GenerateQrCodeDinamis::dispatch($karyawan->id, $forceGenerate);
        
        $this->info("✅ QR Code job dispatched untuk {$karyawan->nama_lengkap}");
    }

    /**
     * Generate QR untuk semua karyawan yang memenuhi syarat
     */
    private function generateForAllEligibleEmployees($forceGenerate = false)
    {
        // Ambil semua karyawan yang memenuhi syarat dasar
        $eligibleEmployees = $this->getEligibleEmployees();
        
        if ($eligibleEmployees->isEmpty()) {
            $this->warn('⚠️  Tidak ada karyawan yang memenuhi syarat untuk generate QR saat ini.');
            return;
        }

        $this->info("📊 Ditemukan {$eligibleEmployees->count()} karyawan yang memenuhi syarat");

        $progressBar = $this->output->createProgressBar($eligibleEmployees->count());
        $progressBar->start();

        $dispatchedCount = 0;

        foreach ($eligibleEmployees as $karyawan) {
            // Dispatch job untuk setiap karyawan
            GenerateQrCodeDinamis::dispatch($karyawan->id, $forceGenerate);
            $dispatchedCount++;
            
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info("✅ {$dispatchedCount} QR Code jobs berhasil di-dispatch");
    }

    /**
     * Dapatkan karyawan yang memenuhi syarat untuk generate QR
     */
    private function getEligibleEmployees()
    {
        $currentShifts = $this->getCurrentActiveShifts();
        
        return Karyawan::where('status_kerja', 'aktif')
            ->where('berhak_konsumsi', true)
            ->whereHas('shift', function($query) use ($currentShifts) {
                $query->whereIn('nama_shift', $currentShifts);
            })
            ->whereHas('shift.pesananMakanan', function($query) {
                // Hanya karyawan yang ada pesanan makanan hari ini
                $query->whereDate('tanggal_pesanan', Carbon::today());
            })
            ->whereDoesntHave('distribusiMakanan', function($query) {
                // Hanya yang belum ambil makanan hari ini
                $query->whereHas('pesananMakanan', function($subQuery) {
                    $subQuery->whereDate('tanggal_pesanan', Carbon::today());
                });
            })
            ->get();
    }

    /**
     * Dapatkan shift yang sedang aktif saat ini
     */
    private function getCurrentActiveShifts()
    {
        $currentHour = Carbon::now()->hour;
        $shifts = [];
        
        // Logika shift (sesuaikan dengan sistem Anda)
        // Shift 1: 07:00 - 15:00 (window: 06:00 - 16:00)
        if ($currentHour >= 6 && $currentHour < 16) {
            $shifts[] = 'Shift 1';
        }
        
        // Shift 2: 15:00 - 23:00 (window: 14:00 - 00:00)
        if ($currentHour >= 14 && $currentHour < 24) {
            $shifts[] = 'Shift 2';
        }
        
        // Shift 3: 23:00 - 07:00 (window: 22:00 - 08:00)
        if ($currentHour >= 22 || $currentHour < 8) {
            $shifts[] = 'Shift 3';
        }

        // Debug info
        $this->line("⏰ Jam sekarang: " . Carbon::now()->format('H:i'));
        $this->line("🔄 Shift aktif: " . implode(', ', $shifts));

        return $shifts;
    }
}