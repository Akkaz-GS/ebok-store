<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ebook;
use App\Models\Review;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
   public function dashboard()
    {
        $userId = auth()->id();

        $totalEbooks = Order::where('buyer_id', $userId)
            ->whereIn('status', ['dibayar', 'selesai'])->count();

        $totalSpent = Order::where('buyer_id', $userId)
            ->whereIn('status', ['dibayar', 'selesai'])->sum('total_price');

        $pendingOrders = Order::where('buyer_id', $userId)
            ->where('status', 'menunggu_verifikasi')->count();

        $totalReviews = Review::where('buyer_id', $userId)->count();
        // ↑ cek juga nama kolom di tabel reviews kalau error berikutnya muncul di sini

        $recentOrders = Order::with('ebook.seller')
            ->where('buyer_id', $userId)->latest()->take(5)->get();

        $recommendedEbooks = Ebook::with(['seller', 'promo'])
            ->where('status', 'aktif')->latest()->take(5)->get();

        return view('pembeli.dashboard', compact(
            'totalEbooks', 'totalSpent', 'pendingOrders', 'totalReviews', 'recentOrders', 'recommendedEbooks'
        ));
    }

    public function library()
    {
        $myEbooks = Order::with('ebook.seller')
            ->where('buyer_id', auth()->id())
            ->whereIn('status', ['dibayar', 'selesai'])
            ->latest()
            ->get();

        return view('pembeli.library', compact('myEbooks'));
    }
}