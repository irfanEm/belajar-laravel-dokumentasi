<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDetail extends Model
{
    /** @use HasFactory<\Database\Factories\ItemDetailFactory> */
    use HasFactory;

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
