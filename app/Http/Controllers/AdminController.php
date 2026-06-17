<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ebook;
use App\Models\Promo;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalUsers'   => User::count(),
            'totalOrders'  => Order::count(),
            'totalRevenue' => Order::whereIn('status',['dibayar','selesai'])->sum('total_price'),
            'activePromos' => Promo::count(),
            'recentUsers'  => User::latest()->take(5)->get(),
            'orderStats'   => [
                'selesai'             => Order::whereIn('status',['dibayar','selesai'])->count(),
                'menunggu_verifikasi' => Order::where('status','menunggu_verifikasi')->count(),
                'ditolak'             => Order::where('status','ditolak')->count(),
            ],
        ]);
    }

    public function laporan(Request $request)
    {
        $query = Order::where('status', 'lunas')->with(['buyer', 'ebook.seller']);

        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }
        if ($request->tahun) {
            $query->whereYear('created_at', $request->tahun);
        }

        $totalPendapatan = (clone $query)->sum('total_price');
        $orders          = $query->latest()->paginate(15);

        $perKategori = Order::where('orders.status', 'lunas')
            ->join('ebooks', 'orders.ebook_id', '=', 'ebooks.id')
            ->join('categories', 'ebooks.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(*) as total, SUM(orders.total_price) as pendapatan')
            ->groupBy('categories.name')
            ->get();

        return view('admin.laporan', compact('orders', 'totalPendapatan', 'perKategori'));
    }
}