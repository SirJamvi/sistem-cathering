<?php

namespace App\Jobs;

use App\Mail\KirimAkunKaryawan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KirimEmailAkun implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $user,
        protected string $password
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Menggunakan Mailable yang sudah kita buat sebelumnya
            $email = new KirimAkunKaryawan($this->user, $this->password);
            Mail::to($this->user->email)->send($email);

            Log::info('Email akun berhasil dikirim ke: ' . $this->user->email);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email akun ke: ' . $this->user->email . '. Error: ' . $e->getMessage());
        }
    }
}