<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_id', 'ebook_id', 'total_price', 'status', 'payment_proof'
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }

    public function download()
    {
        return $this->hasOne(Download::class);
    }

    public function isLunas(): bool
    {
        return $this->status === 'lunas';
    }
}