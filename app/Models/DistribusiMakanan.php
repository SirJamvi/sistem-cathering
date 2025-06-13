<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistribusiMakanan extends Model
{
    use HasFactory;

    protected $table = 'distribusi_makanans';

    protected $fillable = [
        'pesanan_makanan_id',
        'karyawan_id',
        'koki_id',
        'qr_code_dinamis_id',
        'waktu_pengambilan',
        'status_distribusi',
        'catatan',
        'detail_validasi',
    ];

    protected $casts = [
        'waktu_pengambilan' => 'datetime',
        'detail_validasi' => 'json',
    ];

    public function pesananMakanan(): BelongsTo
    {
        return $this->belongsTo(PesananMakanan::class);
    }

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function koki(): BelongsTo
    {
        return $this->belongsTo(Koki::class);
    }

    public function qrCodeDinamis(): BelongsTo
    {
        return $this->belongsTo(QrCodeDinamis::class);
    }
}