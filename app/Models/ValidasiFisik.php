<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\AdminHrga;

class ValidasiFisik extends Model
{
    use HasFactory;

    protected $table = 'validasi_fisiks';

    protected $fillable = [
        'pesanan_makanan_id',
        'admin_hrga_id',
        'jumlah_fisik_diterima',
        'jumlah_kurang',
        'jumlah_rusak',
        'status_validasi',
        'catatan_validasi',
        'waktu_validasi',
        'foto_bukti',
    ];

    protected $casts = [
        'waktu_validasi' => 'datetime',
        'foto_bukti' => 'json',
    ];

    public function pesananMakanan(): BelongsTo
    {
        return $this->belongsTo(PesananMakanan::class);
    }

    public function adminHrga(): BelongsTo
    {
        return $this->belongsTo(AdminHrga::class);
    }
}