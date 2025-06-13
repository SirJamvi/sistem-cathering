<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusKonsumsiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tanggal' => $this->tanggal,
            'sudah_konsumsi' => (bool) $this->sudah_konsumsi,
            'waktu_konsumsi' => $this->waktu_konsumsi ? $this->waktu_konsumsi->toIso8601String() : null,
            'status_kehadiran' => $this->status_kehadiran,
            'catatan' => $this->catatan,
            'shift' => new ShiftResource($this->whenLoaded('shift')),
        ];
    }
}