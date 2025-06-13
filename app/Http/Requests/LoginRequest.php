<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Otorisasi: Siapa saja boleh mencoba login.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk request login.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }
}