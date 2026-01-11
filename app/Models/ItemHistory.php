<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemHistory extends Model
{
    protected $fillable = [
        'item_type',
        'item_id',
        'activity',
        'description',
    ];
}
