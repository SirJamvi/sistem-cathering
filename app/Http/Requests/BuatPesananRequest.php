<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BuatPesananRequest extends FormRequest
{
    /**
     * Otorisasi: Hanya user dengan role 'hrga' yang boleh.
     */
    public function authorize(): bool
    {
        return Auth::check() && $this->user()->hasRole('hrga');
    }

    /**
     * Aturan validasi untuk membuat pesanan makanan.
     */
    public function rules(): array
    {
        return [
            'vendor_id' => 'required|exists:vendors,id',
            'shift_id' => 'required|exists:shifts,id',
            'tanggal_pesanan' => 'required|date|after_or_equal:today',
            'jumlah_porsi_dipesan' => 'required|integer|min:1',
            'catatan_pesanan' => 'nullable|string',
        ];
    }
}