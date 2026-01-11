<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_barang',
        'kategori',
        'lokasi_terakhir',
        'status_id',
        'tanggal_hilang',
        'deskripsi',
        'kontak',
        'image'
    ];
    protected $casts = [
        'tanggal_hilang' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }
}