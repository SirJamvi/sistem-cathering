<?php

namespace App\Console\Commands;

use App\Models\QrCodeDinamis;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ShowQrCode extends Command
{
    protected $signature = 'qr:show {karyawan_id : ID Karyawan}';
    protected $description = 'Tampilkan QR Code aktif untuk karyawan tertentu';

    public function handle()
    {
        $karyawanId = $this->argument('karyawan_id');
        
        $karyawan = Karyawan::find($karyawanId);
        if (!$karyawan) {
            $this->error("❌ Karyawan dengan ID {$karyawanId} tidak ditemukan.");
            return 1;
        }

        $this->info("👤 Karyawan: {$karyawan->nama_lengkap}");
        $this->line("📱 Menampilkan QR Code...");
        $this->newLine();

        // Ambil QR Code aktif
        $activeQr = QrCodeDinamis::where('karyawan_id', $karyawanId)
            ->where('expired_at', '>', Carbon::now())
            ->where('is_used', false)
            ->orderBy('created_at_qr', 'desc')
            ->first();

        if ($activeQr) {
            $this->info("✅ QR Code AKTIF ditemukan:");
            $this->table([
                'Field', 'Value'
            ], [
                ['ID', $activeQr->id],
                ['Token', $activeQr->qr_token],
                ['Hash', substr($activeQr->qr_hash, 0, 20) . '...'],
                ['Dibuat', $activeQr->created_at_qr->format('Y-m-d H:i:s')],
                ['Expired', $activeQr->expired_at->format('Y-m-d H:i:s')],
                ['Status', $activeQr->is_used ? '❌ Sudah Digunakan' : '✅ Belum Digunakan'],
                ['Sisa Waktu', $activeQr->expired_at->diffForHumans()],
            ]);
        } else {
            $this->warn("⚠️  Tidak ada QR Code aktif.");
        }

        // Tampilkan 5 QR terakhir
        $this->newLine();
        $this->info("📊 5 QR Code Terakhir:");
        
        $recentQrs = QrCodeDinamis::where('karyawan_id', $karyawanId)
            ->orderBy('created_at_qr', 'desc')
            ->limit(5)
            ->get();

        if ($recentQrs->count() > 0) {
            $tableData = [];
            foreach ($recentQrs as $qr) {
                $status = $qr->is_used ? '❌ Digunakan' : 
                         ($qr->expired_at < Carbon::now() ? '⏰ Expired' : '✅ Aktif');
                
                $tableData[] = [
                    $qr->id,
                    substr($qr->qr_token, 0, 15) . '...',
                    $qr->created_at_qr->format('H:i:s'),
                    $qr->expired_at->format('H:i:s'),
                    $status
                ];
            }

            $this->table([
                'ID', 'Token (15 char)', 'Dibuat', 'Expired', 'Status'
            ], $tableData);
        } else {
            $this->warn("❌ Belum ada QR Code untuk karyawan ini.");
        }

        return 0;
    }
}