<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    protected $fillable = [
        'seller_id', 'category_id', 'title', 'slug',
        'description', 'price', 'cover', 'file', 'status'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function promo()
    {
        return $this->hasOne(Promo::class)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
    }

    // Harga setelah diskon
    public function getFinalPriceAttribute(): float
    {
        if ($this->promo) {
            return $this->price - ($this->price * $this->promo->discount_percent / 100);
        }
        return (float) $this->price;
    }
}