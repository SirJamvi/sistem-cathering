<?php

namespace App\Jobs;

use App\Models\Karyawan;
use App\Models\QrCodeDinamis;
use App\Models\PesananMakanan;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GenerateQrCodeDinamis implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    protected $karyawanId;
    protected $forceGenerate;

    /**
     * Create a new job instance.
     */
    public function __construct($karyawanId = null, $forceGenerate = false)
    {
        $this->karyawanId = $karyawanId;
        $this->forceGenerate = $forceGenerate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('GenerateQrCodeDinamis job started', [
                'karyawan_id' => $this->karyawanId,
                'force_generate' => $this->forceGenerate
            ]);

            // Jika ada karyawan specific, hanya generate untuk karyawan tersebut
            if ($this->karyawanId) {
                $this->generateForSpecificEmployee($this->karyawanId);
            } else {
                // Generate untuk semua karyawan yang memenuhi syarat
                $this->generateForAllEligibleEmployees();
            }

            // Cleanup expired QR codes (optional, jangan terlalu agresif)
            // $this->cleanupExpiredQrCodes();

            Log::info('GenerateQrCodeDinamis job completed successfully');

        } catch (\Exception $e) {
            Log::error('GenerateQrCodeDinamis job failed', [
                'karyawan_id' => $this->karyawanId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-throw untuk memicu retry mechanism
            throw $e;
        }
    }

    /**
     * Generate QR untuk karyawan spesifik
     */
    private function generateForSpecificEmployee($karyawanId)
    {
        $karyawan = Karyawan::find($karyawanId);
        
        if (!$karyawan) {
            Log::warning('Karyawan tidak ditemukan', ['karyawan_id' => $karyawanId]);
            return;
        }

        Log::info('Processing karyawan', [
            'id' => $karyawan->id,
            'nama' => $karyawan->nama_lengkap,
            'status_kerja' => $karyawan->status_kerja,
            'berhak_konsumsi' => $karyawan->berhak_konsumsi
        ]);

        if ($this->isEligibleForQrGeneration($karyawan)) {
            // Expire QR code lama jika ada (opsional)
            if ($this->forceGenerate) {
                $this->expireOldQrCodes($karyawan->id);
            }
            
            $this->createNewQrCode($karyawan);
            Log::info('✅ QR Code berhasil dibuat untuk karyawan', [
                'karyawan_id' => $karyawan->id,
                'nama' => $karyawan->nama_lengkap
            ]);
        } else {
            Log::info('❌ Karyawan tidak memenuhi syarat untuk QR Code', [
                'karyawan_id' => $karyawan->id,
                'nama' => $karyawan->nama_lengkap
            ]);
        }
    }

    /**
     * Generate QR untuk semua karyawan yang memenuhi syarat
     */
    private function generateForAllEligibleEmployees()
    {
        // Ambil semua karyawan yang sedang aktif dan berhak konsumsi
        $karyawanList = Karyawan::where('status_kerja', 'aktif')
            ->where('berhak_konsumsi', true)
            ->get();

        Log::info('Total karyawan aktif dan berhak konsumsi', [
            'count' => $karyawanList->count()
        ]);

        $generatedCount = 0;
        
        foreach ($karyawanList as $karyawan) {
            if ($this->isEligibleForQrGeneration($karyawan)) {
                // Expire QR code lama terlebih dahulu jika force
                if ($this->forceGenerate) {
                    $this->expireOldQrCodes($karyawan->id);
                }
                
                // Buat QR code baru
                $this->createNewQrCode($karyawan);
                $generatedCount++;
                
                Log::info('QR Code generated', [
                    'karyawan_id' => $karyawan->id,
                    'nama' => $karyawan->nama_lengkap
                ]);
            }
        }

        Log::info('Bulk QR generation completed', [
            'total_employees' => $karyawanList->count(),
            'generated_count' => $generatedCount
        ]);
    }

    /**
     * Cek apakah karyawan memenuhi syarat untuk generate QR
     */
    private function isEligibleForQrGeneration($karyawan)
    {
        // Cek status karyawan
        if (!$karyawan->berhak_konsumsi || $karyawan->status_kerja != 'aktif') {
            Log::debug('Karyawan tidak eligible - status', [
                'karyawan_id' => $karyawan->id,
                'berhak_konsumsi' => $karyawan->berhak_konsumsi,
                'status_kerja' => $karyawan->status_kerja
            ]);
            return false;
        }

        // Cek apakah ada pesanan makanan untuk shift hari ini
        $pesanan = PesananMakanan::where('shift_id', $karyawan->shift_id)
            ->whereDate('tanggal_pesanan', Carbon::today())
            ->first();

        if (!$pesanan) {
            Log::debug('Tidak ada pesanan makanan untuk shift hari ini', [
                'karyawan_id' => $karyawan->id,
                'shift_id' => $karyawan->shift_id,
                'tanggal' => Carbon::today()->toDateString()
            ]);
            return false;
        }

        // Cek apakah karyawan sudah mengambil makanan hari ini
        $sudahAmbil = \App\Models\DistribusiMakanan::where('pesanan_makanan_id', $pesanan->id)
            ->where('karyawan_id', $karyawan->id)
            ->exists();

        if ($sudahAmbil) {
            Log::debug('Karyawan sudah mengambil makanan hari ini', [
                'karyawan_id' => $karyawan->id,
                'pesanan_id' => $pesanan->id
            ]);
            return false; // Sudah ambil, tidak perlu QR baru
        }

        // Jika force generate, skip cek QR yang masih valid
        if ($this->forceGenerate) {
            Log::debug('Force generate - skip existing QR check', [
                'karyawan_id' => $karyawan->id
            ]);
            return true;
        }

        // Cek apakah masih ada QR yang valid (belum expired dan belum digunakan)
        $activeQr = QrCodeDinamis::where('karyawan_id', $karyawan->id)
            ->where('expired_at', '>', Carbon::now())
            ->where('is_used', false)
            ->first();

        if ($activeQr) {
            Log::debug('Karyawan sudah memiliki QR aktif', [
                'karyawan_id' => $karyawan->id,
                'qr_id' => $activeQr->id,
                'expired_at' => $activeQr->expired_at->toIso8601String()
            ]);
            return false;
        }

        Log::debug('Karyawan eligible untuk QR baru', [
            'karyawan_id' => $karyawan->id
        ]);

        return true;
    }

    /**
     * Expire QR codes lama untuk karyawan
     */
    private function expireOldQrCodes($karyawanId)
    {
        $updated = QrCodeDinamis::where('karyawan_id', $karyawanId)
            ->where('is_used', false)
            ->where('expired_at', '>', Carbon::now())
            ->update([
                'expired_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        if ($updated > 0) {
            Log::debug('Expired old QR codes', [
                'karyawan_id' => $karyawanId,
                'expired_count' => $updated
            ]);
        }
    }

    /**
     * Buat QR code baru untuk karyawan
     */
    private function createNewQrCode($karyawan)
    {
        $token = Str::random(60);
        // Perpanjang waktu expired untuk testing - bisa disesuaikan
        $expirationTime = Carbon::now()->addMinutes(5); // Ubah dari 15 detik ke 5 menit untuk testing

        $qrCode = QrCodeDinamis::create([
            'karyawan_id' => $karyawan->id,
            'qr_token' => $token,
            'qr_hash' => hash('sha256', $token),
            'created_at_qr' => Carbon::now(),
            'expired_at' => $expirationTime,
            'is_used' => false,
            'generated_ip' => request()->ip() ?? '127.0.0.1', // Fallback untuk background job
        ]);

        Log::info('✅ New QR code created successfully', [
            'qr_id' => $qrCode->id,
            'karyawan_id' => $karyawan->id,
            'karyawan_nama' => $karyawan->nama_lengkap,
            'token' => substr($token, 0, 10) . '...',
            'created_at' => $qrCode->created_at_qr->toIso8601String(),
            'expired_at' => $expirationTime->toIso8601String(),
            'valid_for' => $expirationTime->diffForHumans()
        ]);
    }

    /**
     * Cleanup QR codes yang sudah expired (panggil dengan hati-hati)
     */
    private function cleanupExpiredQrCodes()
    {
        // Hanya hapus QR yang sudah expired lebih dari 1 jam
        $expiredCount = QrCodeDinamis::where('expired_at', '<', Carbon::now()->subHour())
            ->delete();

        if ($expiredCount > 0) {
            Log::info('Expired QR codes cleaned up', [
                'deleted_count' => $expiredCount
            ]);
        }
    }

    /**
     * Get shift yang aktif hari ini
     */
    private function getActiveShiftsToday()
    {
        $currentHour = Carbon::now()->hour;
        
        // Definisi jam shift (sesuaikan dengan sistem Anda)
        $shifts = [];
        
        // Shift 1: 07:00 - 15:00
        if ($currentHour >= 6 && $currentHour < 16) {
            $shifts[] = 'Shift 1';
        }
        
        // Shift 2: 15:00 - 23:00
        if ($currentHour >= 14 && $currentHour < 24) {
            $shifts[] = 'Shift 2';
        }
        
        // Shift 3: 23:00 - 07:00 (malam)
        if ($currentHour >= 22 || $currentHour < 8) {
            $shifts[] = 'Shift 3';
        }

        // Fallback: jika tidak ada shift aktif, return semua shift
        return empty($shifts) ? ['Shift 1', 'Shift 2', 'Shift 3'] : $shifts;
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return ['qr-generation', 'karyawan:' . ($this->karyawanId ?? 'all')];
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [5, 10, 30]; // Retry after 5s, 10s, 30s
    }

    /**
     * Determine the time at which the job should timeout.
     */
    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(2);
    }
}