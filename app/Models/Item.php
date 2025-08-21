<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'price',
        'menu_id',
        'item_category_id',
        'image',
        'status',
    ];

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SalesItem::class);
    }
    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id');
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
    public function variations()
    {
        return $this->hasMany(MenuVariation::class, 'item_id');
    }
    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/' . $this->image) : 'https://via.placeholder.com/100';
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status ? 'success' : 'danger';
    }

    public function getStatusBadgeAttribute(): string
    {
        return '<span class="badge badge-' . $this->statusColor . '">' . $this->statusLabel . '</span>';
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }
    protected static function boot()
    {
        parent::boot();
        static::created(function ($record) {
            
            $record->sku = uniqid('sku_' .  date('yd') . $record->id);
            $record->save();
            
        });
        static::updated(function ($data) {
             
            if (empty($data->sku))
                $data->sku = uniqid('sku_' .  date('yd') . $data->id);
            $data->save();
        });
    }
}
