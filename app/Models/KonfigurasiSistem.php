<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfigurasiSistem extends Model
{
    use HasFactory;

    protected $table = 'konfigurasi_sistems';

    protected $fillable = [
        'key',
        'value',
        'group',
        'description',
        'type',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];
}