<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QrCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        // Hanya kirim data yang aman dan dibutuhkan oleh klien
        return [
            'qr_token' => $this->qr_token,
            'expired_at' => $this->expired_at->toIso8601String(),
        ];
    }
}