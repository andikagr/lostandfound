<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;
    protected $table = 'claims';

    protected $fillable = [
        'found_item_id',
        'lost_item_id',
        'user_id',
        'nama_pemilik',
        'kontak_pemilik',
        'lokasi_terakhir',
        'bukti',
        'status',
    ];

    public function foundItem()
    {
        return $this->belongsTo(\App\Models\FoundItem::class, 'found_item_id');
    }

    public function lostItem()
    {
        return $this->belongsTo(\App\Models\LostItem::class, 'lost_item_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}