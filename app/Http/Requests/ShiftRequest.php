<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ShiftRequest extends FormRequest
{
    /**
     * Otorisasi: Hanya HRGA yang boleh mengelola shift.
     */
    public function authorize(): bool
    {
        return Auth::check() && $this->user()->hasRole('hrga');
    }

    /**
     * Aturan validasi untuk data shift.
     */
    public function rules(): array
    {
        // Dapatkan shift dari parameter route jika ada (untuk proses update)
        $shiftId = $this->route('shift') ? $this->route('shift')->id : null;

        return [
            'nama_shift' => ['required', 'string', 'max:255', Rule::unique('shifts')->ignore($shiftId)],
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'jam_makan_mulai' => 'required|date_format:H:i',
            'jam_makan_selesai' => 'required|date_format:H:i|after:jam_makan_mulai',
            'keterangan' => 'nullable|string',
            'is_active' => 'required|boolean',
        ];
    }
}