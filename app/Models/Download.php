<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $fillable = [
        'order_id', 'buyer_id', 'ebook_id', 'downloaded_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}