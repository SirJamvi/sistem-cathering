<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_vendor' => $this->nama_vendor,
            'kontak_person' => $this->kontak_person,
            'phone' => $this->phone,
        ];
    }
}