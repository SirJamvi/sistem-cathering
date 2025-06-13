<?php

namespace App\Jobs;

use App\Models\DistribusiMakanan;
use App\Models\LaporanHarian;
use App\Models\PesananMakanan;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateLaporanHarian implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Carbon $tanggal
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Memulai proses generate laporan harian untuk tanggal: ' . $this->tanggal->toDateString());

        // Ambil semua shift yang aktif
        $shifts = Shift::where('is_active', true)->get();

        foreach ($shifts as $shift) {
            $pesanan = PesananMakanan::where('shift_id', $shift->id)
                ->whereDate('tanggal_pesanan', $this->tanggal)
                ->first();

            if (!$pesanan) {
                continue; // Lanjut ke shift berikutnya jika tidak ada pesanan
            }

            $totalDipesan = $pesanan->jumlah_porsi_dipesan;
            $totalDikonsumsi = DistribusiMakanan::where('pesanan_makanan_id', $pesanan->id)->count();
            $totalSisa = $totalDipesan - $totalDikonsumsi;
            $persentaseKonsumsi = ($totalDipesan > 0) ? ($totalDikonsumsi / $totalDipesan) * 100 : 0;

            // Buat atau update laporan harian
            LaporanHarian::updateOrCreate(
                [
                    'tanggal' => $this->tanggal->toDateString(),
                    'shift_id' => $shift->id,
                ],
                [
                    'pesanan_makanan_id' => $pesanan->id,
                    'total_karyawan_hadir' => 0, // Perlu logika tambahan jika ingin melacak kehadiran
                    'total_porsi_dipesan' => $totalDipesan,
                    'total_porsi_dikonsumsi' => $totalDikonsumsi,
                    'total_porsi_sisa' => $totalSisa,
                    'persentase_konsumsi' => round($persentaseKonsumsi, 2),
                    'dibuat_oleh' => $pesanan->admin_hrga_id, // Diasumsikan dibuat oleh admin yg sama
                ]
            );
        }
        
        Log::info('Proses generate laporan harian selesai.');
    }
}