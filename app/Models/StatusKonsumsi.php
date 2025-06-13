<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusKonsumsi extends Model
{
    use HasFactory;

    protected $table = 'status_konsumsis';

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'shift_id',
        'sudah_konsumsi',
        'waktu_konsumsi',
        'status_kehadiran',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'sudah_konsumsi' => 'boolean',
        'waktu_konsumsi' => 'datetime',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }
}