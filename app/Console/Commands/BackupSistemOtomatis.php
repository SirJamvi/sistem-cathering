<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class BackupSistemOtomatis extends Command
{
    /**
     * Nama dan signature dari console command.
     */
    protected $signature = 'sistem:backup';

    /**
     * Deskripsi dari console command.
     */
    protected $description = 'Menjalankan backup database dan file aplikasi menggunakan spatie/laravel-backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses backup sistem...');
        Log::info('Memulai proses backup terjadwal...');

        try {
            // Menjalankan command backup dari spatie
            Artisan::call('backup:run');
            $this->info('Backup database dan file berhasil dijalankan.');

            // Menjalankan command untuk membersihkan backup lama
            Artisan::call('backup:clean');
            $this->info('Backup lama berhasil dibersihkan.');
            
            Log::info('Proses backup terjadwal berhasil diselesaikan.');
            $this->info('Proses backup sistem selesai.');

        } catch (\Exception $e) {
            Log::error('Proses backup terjadwal gagal: ' . $e->getMessage());
            $this->error('Terjadi kesalahan saat menjalankan backup: ' . $e->getMessage());
        }
    }
}