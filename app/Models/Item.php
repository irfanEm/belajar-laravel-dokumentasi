<?php

namespace App\Models;

use App\Models\ItemDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    // customize resolution logic with resolveRouteBinding method.
    // public function resolveRouteBinding($value, $field = null)
    // {
    //     return $this->where('name', $value)->firstOrFail();
    // }

    public function details()
    {
        return $this->hasMany(ItemDetail::class);
    }

    // customize resolution logic with resolveRouteBinding method.
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        return $this->where($field ?? 'id', $value)->firstOrFail();
    }
}
