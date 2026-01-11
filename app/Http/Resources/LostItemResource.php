<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LostItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'nama_barang' => $this->nama_barang,
            'kategori' => $this->kategori,
            'lokasi_terakhir' => $this->lokasi_terakhir,
            'status_id' => $this->status_id,
            'tanggal_hilang' => $this->tanggal_hilang,
            'deskripsi' => $this->deskripsi,
            'kontak' => $this->kontak,
            'image_url' => $this->image ? url('storage/' . $this->image) : null,
            'created_at' => $this->created_at,
        ];
    }
}