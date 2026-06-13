<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // app/Models/User.php
    protected $fillable = ['name', 'email', 'password', 'role'];

// Relasi
    public function ebooks()
    {
        return $this->hasMany(Ebook::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'buyer_id');
    }

// Helper cek role
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isPenjual(): bool  { return $this->role === 'penjual'; }
    public function isPembeli(): bool  { return $this->role === 'pembeli'; }
}
