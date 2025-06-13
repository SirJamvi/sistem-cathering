<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = [
        'nama_vendor',
        'kontak_person',
        'email',
        'phone',
        'alamat',
        'status_kontrak',
        'tanggal_kontrak_mulai',
        'tanggal_kontrak_berakhir',
        'harga_per_porsi',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kontrak_mulai' => 'date',
        'tanggal_kontrak_berakhir' => 'date',
        'harga_per_porsi' => 'decimal:2',
    ];

    public function pesananMakanan(): HasMany
    {
        return $this->hasMany(PesananMakanan::class);
    }

    public function laporanBulanan(): HasMany
    {
        return $this->hasMany(LaporanBulanan::class);
    }
}