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

    protected User $user;
    protected string $password;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;

        // Log saat job dibuat dan masuk ke antrian
        Log::info("Job KirimEmailAkun dibuat untuk user: {$this->user->email}");
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Log saat job mulai dieksekusi oleh worker (atau sync)
        Log::info("--> Memulai eksekusi job KirimEmailAkun untuk: {$this->user->email}");

        try {
            // Membuat instance Mailable
            $email = new KirimAkunKaryawan($this->user, $this->password);
            Log::info("    |-- Mailable KirimAkunKaryawan berhasil dibuat.");

            // Mengirim email
            Mail::to($this->user->email)->send($email);
            Log::info("    |-- Perintah Mail::send() berhasil dieksekusi.");

            // Log sukses akhir
            Log::info("--> [SUCCESS] Eksekusi job KirimEmailAkun selesai untuk: {$this->user->email}");

        } catch (\Exception $e) {
            // Log jika terjadi error saat pengiriman
            Log::error("--> [FAILED] Gagal mengirim email akun ke: {$this->user->email}. Error: {$e->getMessage()}");
        }
    }
}
