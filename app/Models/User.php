<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <-- 1. IMPORT TRAIT INI
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\AdminHrga;
use App\Models\Karyawan; // <-- TAMBAHKAN INI
use App\Models\Koki;     // <-- TAMBAHKAN INI

class User extends Authenticatable
{
    // 2. GUNAKAN TRAIT DI SINI
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the admin hrga record associated with the user.
     */
    public function adminHrga(): HasOne
    {
        return $this->hasOne(AdminHrga::class);
    }

    /**
     * Get the karyawan record associated with the user.
     */
    public function karyawan(): HasOne
    {
        return $this->hasOne(Karyawan::class);
    }

    /**
     * Get the koki record associated with the user.
     */
    public function koki(): HasOne
    {
        return $this->hasOne(Koki::class);
    }
}
