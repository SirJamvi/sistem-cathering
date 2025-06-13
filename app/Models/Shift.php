<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';

    protected $fillable = [
        'nama_shift',
        'jam_mulai',
        'jam_selesai',
        'jam_makan_mulai',
        'jam_makan_selesai',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function karyawan(): HasMany
    {
        return $this->hasMany(Karyawan::class);
    }

    public function pesananMakanan(): HasMany
    {
        return $this->hasMany(PesananMakanan::class);
    }

    public function laporanHarian(): HasMany
    {
        return $this->hasMany(LaporanHarian::class);
    }
}