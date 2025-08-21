<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class ItemCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
        
    ];
    public function items()
    {
        return $this->hasMany(Item::class, 'item_category_id');
    }

}
