<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidasiFisikRequest extends FormRequest
{
    /**
     * Otorisasi: Hanya user dengan role 'hrga' yang boleh melakukan validasi fisik.
     */
    public function authorize(): bool
    {
        return Auth::check() && $this->user()->hasRole('hrga');
    }

    /**
     * Aturan validasi untuk data validasi fisik.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pesanan_makanan_id' => 'required|exists:pesanan_makanans,id',
            'jumlah_fisik_diterima' => 'required|integer|min:0',
            'jumlah_rusak' => 'required|integer|min:0',
            'catatan_validasi' => 'nullable|string',
        ];
    }
}