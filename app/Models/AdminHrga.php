<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminHrga extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'admin_hrgas';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'email',
        'phone',
        'level_akses',
        'status',
    ];

    /**
     * Mendefinisikan relasi ke model User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi ke model PesananMakanan.
     */
    public function pesananMakanan(): HasMany
    {
        return $this->hasMany(PesananMakanan::class);
    }

    /**
     * Mendefinisikan relasi ke model ValidasiFisik.
     */
    public function validasiFisik(): HasMany
    {
        return $this->hasMany(ValidasiFisik::class);
    }
}