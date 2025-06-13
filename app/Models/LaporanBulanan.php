<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\AdminHrga;

class LaporanBulanan extends Model
{
    use HasFactory;

    protected $table = 'laporan_bulanans';

    protected $fillable = [
        'bulan',
        'tahun',
        'vendor_id',
        'total_hari_operasional',
        'total_porsi_dipesan',
        'total_porsi_dikonsumsi',
        'total_porsi_sisa',
        'total_biaya',
        'rata_rata_konsumsi_harian',
        'persentase_efektivitas',
        'detail_per_shift',
        'detail_per_divisi',
        'trend_konsumsi',
        'evaluasi',
        'rekomendasi',
        'dibuat_oleh',
    ];

    protected $casts = [
        'total_biaya' => 'decimal:2',
        'rata_rata_konsumsi_harian' => 'decimal:2',
        'persentase_efektivitas' => 'decimal:2',
        'detail_per_shift' => 'json',
        'detail_per_divisi' => 'json',
        'trend_konsumsi' => 'json',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(AdminHrga::class, 'dibuat_oleh');
    }
}