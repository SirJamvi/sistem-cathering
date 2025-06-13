<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\KaryawanResource; // <-- Ditambahkan
use App\Http\Resources\KokiResource; // <-- Ditambahkan

class DistribusiMakananResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'waktu_pengambilan' => $this->waktu_pengambilan->toIso8601String(),
            'status_distribusi' => $this->status_distribusi,
            'catatan' => $this->catatan,
            'karyawan' => new KaryawanResource($this->whenLoaded('karyawan')),
            'koki' => new KokiResource($this->whenLoaded('koki')),
        ];
    }
}