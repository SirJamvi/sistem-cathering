<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogScanQr extends Model
{
    use HasFactory;

    protected $table = 'log_scan_qrs';

    protected $fillable = [
    'karyawan_id',
    'koki_id',
    'qr_code_dinamis_id',
    'qr_token_scanned',
    'waktu_scan', // Pastikan ini ada
    'hasil_scan',
    'pesan_error',
    'detail_validasi',
    'ip_scanner',
    'device_info'
];

    protected $casts = [
        'waktu_scan' => 'datetime',
        'detail_validasi' => 'json',
    ];

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