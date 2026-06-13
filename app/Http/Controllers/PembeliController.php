<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ebook;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function dashboard()
    {
        $totalBeli     = Order::where('buyer_id', auth()->id())->count();
        $totalLunas    = Order::where('buyer_id', auth()->id())->where('status', 'lunas')->count();
        $totalPending  = Order::where('buyer_id', auth()->id())->where('status', 'pending')->count();

        $orderTerbaru  = Order::where('buyer_id', auth()->id())
                              ->with(['ebook.category'])
                              ->latest()->take(5)->get();

        $rekomendasiEbook = Ebook::where('status', 'aktif')
                                 ->whereNotIn('id', Order::where('buyer_id', auth()->id())
                                     ->where('status', 'lunas')->pluck('ebook_id'))
                                 ->with(['category', 'promo'])
                                 ->latest()->take(4)->get();

        return view('pembeli.dashboard', compact(
            'totalBeli', 'totalLunas', 'totalPending',
            'orderTerbaru', 'rekomendasiEbook'
        ));
    }
}