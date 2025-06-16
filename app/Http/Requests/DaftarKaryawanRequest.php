<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class DaftarKaryawanRequest extends FormRequest
{
    /**
     * Otorisasi: Hanya user dengan role 'hrga' yang boleh.
     */
    public function authorize(): bool
    {
        return Auth::check() && $this->user()->hasRole('hrga');
    }

    /**
     * Aturan validasi untuk mendaftarkan karyawan baru.
     */
    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'nip' => 'required|string|max:255|unique:karyawans,nip',
            'divisi_id' => 'required|exists:divisis,id',
            'shift_id' => 'required|exists:shifts,id',
            'tanggal_bergabung' => 'required|date',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }
}