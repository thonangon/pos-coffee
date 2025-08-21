<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'variation_name',
        'price',
    ];
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
