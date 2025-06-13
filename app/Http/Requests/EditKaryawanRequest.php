<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EditKaryawanRequest extends FormRequest
{
    /**
     * Otorisasi: Hanya user dengan role 'hrga' yang boleh.
     */
    public function authorize(): bool
    {
        return Auth::check() && $this->user()->hasRole('hrga');
    }

    /**
     * Aturan validasi untuk mengedit data karyawan.
     */
    public function rules(): array
    {
        // Mengambil karyawan dari parameter route
        $karyawan = $this->route('karyawan'); 

        return [
            'nama_lengkap' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($karyawan->user_id)],
            'nip' => ['required', 'string', 'max:255', Rule::unique('karyawans')->ignore($karyawan->id)],
            'divisi_id' => 'required|exists:divisis,id',
            'shift_id' => 'required|exists:shifts,id',
            'status_kerja' => 'required|in:aktif,cuti,sakit,non_aktif',
            'berhak_konsumsi' => 'required|boolean',
            'phone' => 'nullable|string|max:20',
        ];
    }
}