<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\AdminHrga;

class LaporanHarian extends Model
{
    use HasFactory;

    protected $table = 'laporan_harians';

    protected $fillable = [
        'tanggal',
        'shift_id',
        'pesanan_makanan_id',
        'total_karyawan_hadir',
        'total_porsi_dipesan',
        'total_porsi_dikonsumsi',
        'total_porsi_sisa',
        'persentase_konsumsi',
        'detail_per_divisi',
        'catatan',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'persentase_konsumsi' => 'decimal:2',
        'detail_per_divisi' => 'json',
    ];

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function pesananMakanan(): BelongsTo
    {
        return $this->belongsTo(PesananMakanan::class);
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(AdminHrga::class, 'dibuat_oleh');
    }
}