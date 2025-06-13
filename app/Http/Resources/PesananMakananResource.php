<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\VendorResource; // <-- Ditambahkan
use App\Http\Resources\ShiftResource; // <-- Ditambahkan
use App\Http\Resources\AdminHrgaResource; // <-- Ditambahkan

class PesananMakananResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tanggal_pesanan' => $this->tanggal_pesanan,
            'jumlah_porsi_dipesan' => $this->jumlah_porsi_dipesan,
            'total_harga' => number_format($this->total_harga, 2, ',', '.'),
            'status_pesanan' => $this->status_pesanan,
            'waktu_pengiriman_estimasi' => $this->waktu_pengiriman_estimasi,
            'catatan' => $this->catatan_pesanan,
            'menu' => $this->menu_detail,
            'vendor' => new VendorResource($this->whenLoaded('vendor')),
            'shift' => new ShiftResource($this->whenLoaded('shift')),
            'dibuat_oleh' => new AdminHrgaResource($this->whenLoaded('adminHrga')),
        ];
    }
}