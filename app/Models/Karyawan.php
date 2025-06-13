<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;                      // ✱ import Carbon
use App\Models\DistribusiMakanan;                    // ✱ import model DistribusiMakanan

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';

    protected $fillable = [
        'user_id',
        'divisi_id',
        'shift_id',
        'nip',
        'nama_lengkap',
        'email',
        'phone',
        'status_kerja',
        'tanggal_bergabung',
        'berhak_konsumsi',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
        'berhak_konsumsi'   => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function qrCodeDinamis(): HasMany
    {
        return $this->hasMany(QrCodeDinamis::class);
    }

    public function distribusiMakanan(): HasMany
    {
        return $this->hasMany(DistribusiMakanan::class);
    }

    /**
     * Distribusi makanan hanya untuk hari ini
     */
    public function distribusiMakananHariIni(): HasMany
    {
        return $this->hasMany(DistribusiMakanan::class)
                    ->whereDate('waktu_pengambilan', Carbon::today());
    }

    public function statusKonsumsi(): HasMany
    {
        return $this->hasMany(StatusKonsumsi::class);
    }

    public function logScanQr(): HasMany
    {
        return $this->hasMany(LogScanQr::class);
    }
}
