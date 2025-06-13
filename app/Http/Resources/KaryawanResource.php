<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DivisiResource; // <-- Ditambahkan
use App\Http\Resources\ShiftResource; // <-- Ditambahkan

class KaryawanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nip' => $this->nip,
            'nama_lengkap' => $this->nama_lengkap,
            'email' => $this->email,
            'phone' => $this->phone,
            'status_kerja' => $this->status_kerja,
            'tanggal_bergabung' => $this->tanggal_bergabung,
            'berhak_konsumsi' => $this->berhak_konsumsi,
            'divisi' => new DivisiResource($this->whenLoaded('divisi')),
            'shift' => new ShiftResource($this->whenLoaded('shift')),
        ];
    }
}