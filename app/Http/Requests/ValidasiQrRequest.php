<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidasiQrRequest extends FormRequest
{
    /**
     * Otorisasi: Hanya user dengan role 'koki' yang boleh melakukan scan QR.
     */
    public function authorize(): bool
    {
        return Auth::check() && $this->user()->hasRole('koki');
    }

    /**
     * Aturan validasi untuk QR Token.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'qr_token' => 'required|string|size:60', // Asumsi panjang token adalah 60 karakter
        ];
    }
}