<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidasiDistribusiRequest extends FormRequest
{
    /**
     * Otorisasi: Hanya user dengan role 'koki' yang boleh.
     */
    public function authorize(): bool
    {
        return Auth::check() && $this->user()->hasRole('koki');
    }

    /**
     * Aturan validasi untuk scan QR.
     */
    public function rules(): array
    {
        return [
            'qr_token' => 'required|string|size:60', // Asumsi token panjangnya 60 karakter
        ];
    }
}