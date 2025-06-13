<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VendorRequest extends FormRequest
{
    /**
     * Otorisasi: Hanya HRGA yang boleh mengelola vendor.
     */
    public function authorize(): bool
    {
        return Auth::check() && $this->user()->hasRole('hrga');
    }

    /**
     * Aturan validasi untuk data vendor.
     */
    public function rules(): array
    {
        $vendorId = $this->route('vendor') ? $this->route('vendor')->id : null;

        return [
            'nama_vendor' => 'required|string|max:255',
            'kontak_person' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('vendors')->ignore($vendorId)],
            'phone' => 'required|string|max:20',
            'alamat' => 'required|string',
            'status_kontrak' => 'required|in:aktif,non_aktif,suspended',
            'tanggal_kontrak_mulai' => 'required|date',
            'tanggal_kontrak_berakhir' => 'required|date|after_or_equal:tanggal_kontrak_mulai',
            'harga_per_porsi' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ];
    }
}