<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LaporanFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && $this->user()->hasRole('hrga');
    }

    public function rules(): array
    {
        return [
            'tanggal' => 'nullable|date',
            'bulan' => 'nullable|integer|between:1,12',
            'tahun' => 'nullable|integer|digits:4',
            'shift_id' => 'nullable|exists:shifts,id',
            'vendor_id' => 'nullable|exists:vendors,id',
        ];
    }
}