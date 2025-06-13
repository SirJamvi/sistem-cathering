<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Koki extends Model
{
    use HasFactory;

    protected $table = 'kokis';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'email',
        'phone',
        'status',
        'shift_bertugas',
    ];

    protected $casts = [
        'shift_bertugas' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function distribusiMakanan(): HasMany
    {
        return $this->hasMany(DistribusiMakanan::class);
    }

    public function logScanQr(): HasMany
    {
        return $this->hasMany(LogScanQr::class);
    }
}