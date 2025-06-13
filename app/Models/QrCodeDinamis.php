<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrCodeDinamis extends Model
{
    use HasFactory;

    protected $table = 'qr_code_dinamis';

    protected $fillable = [
        'karyawan_id',
        'qr_token',
        'qr_hash',
        'created_at_qr',
        'expired_at',
        'is_used',
        'used_at',
        'generated_ip',
    ];

    protected $casts = [
        'created_at_qr' => 'datetime',
        'expired_at' => 'datetime',
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }
}