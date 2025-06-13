<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KirimAkunKaryawan extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Properti publik akan otomatis tersedia di dalam view.
     */
    public function __construct(
        public User $user,
        public string $password
    ) {}

    /**
     * Mendapatkan amplop pesan (subjek, pengirim, penerima).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informasi Akun Anda untuk Sistem Catering Pabrik',
        );
    }

    /**
     * Mendapatkan definisi konten pesan.
     */
    public function content(): Content
    {
        return new Content(
            // Tampilan Blade untuk email ini
            view: 'emails.auth.akun-karyawan', 
            // Data yang akan dikirim ke view
            with: [
                'nama' => $this->user->name,
                'email' => $this->user->email,
                'passwordSementara' => $this->password,
            ],
        );
    }

    /**
     * Mendapatkan lampiran untuk pesan.
     */
    public function attachments(): array
    {
        return [];
    }
}