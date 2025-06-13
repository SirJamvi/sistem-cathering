<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\VendorResource; // <-- Ditambahkan
use App\Http\Resources\ShiftResource; // <-- Ditambahkan
use App\Http\Resources\AdminHrgaResource; // <-- Ditambahkan
use App\Http\Resources\PesananMakananResource; // <-- Ditambahkan

class LaporanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        // Menggabungkan semua atribut dari model asli
        return array_merge(parent::toArray($request), [
            // Menambahkan data relasi jika di-load
            'vendor' => new VendorResource($this->whenLoaded('vendor')),
            'shift' => new ShiftResource($this->whenLoaded('shift')),
            'pembuat' => new AdminHrgaResource($this->whenLoaded('pembuat')),
            'pesanan' => new PesananMakananResource($this->whenLoaded('pesananMakanan')),
        ]);
    }
}