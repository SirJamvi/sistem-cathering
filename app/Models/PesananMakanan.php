<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\AdminHrga;

class PesananMakanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan_makanans';

    protected $fillable = [
        'admin_hrga_id',
        'vendor_id',
        'shift_id',
        'tanggal_pesanan',
        'jumlah_porsi_dipesan',
        'total_harga',
        'status_pesanan',
        'waktu_pengiriman_estimasi',
        'catatan_pesanan',
        'menu_detail',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'date',
        'total_harga' => 'decimal:2',
        'waktu_pengiriman_estimasi' => 'datetime',
        'menu_detail' => 'json',
    ];

    public function adminHrga(): BelongsTo
    {
        return $this->belongsTo(AdminHrga::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function distribusiMakanan(): HasMany
    {
        return $this->hasMany(DistribusiMakanan::class);
    }

    public function laporanHarian(): HasOne
    {
        return $this->hasOne(LaporanHarian::class);
    }

    public function validasiFisik(): HasOne
    {
        return $this->hasOne(ValidasiFisik::class);
    }
}