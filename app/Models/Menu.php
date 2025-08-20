<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_name',
        
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'menu_id');
    }
}
