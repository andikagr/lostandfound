<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoundItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_barang' => $this->nama_barang,
            'kategori' => $this->kategori,
            'lokasi' => $this->lokasi,
            'tanggal_ditemukan' => $this->tanggal_ditemukan,
            'waktu_ditemukan' => $this->waktu_ditemukan,
            'lokasi_penemuan' => $this->lokasi_penemuan,
            'kronologi' => $this->kronologi,
            'nama_penemu' => $this->nama_penemu,
            'kontak_penemu' => $this->kontak_penemu,
            'alamat_penemu' => $this->alamat_penemu,
            'kontak' => $this->kontak,
            'deskripsi' => $this->deskripsi,
            'image_url' => $this->image ? url('storage/' . $this->image) : null,
            'created_at' => $this->created_at,
        ];
    }
}