<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ebook;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPembeli   = User::where('role', 'pembeli')->count();
        $totalPenjual   = User::where('role', 'penjual')->count();
        $totalEbook     = Ebook::count();
        $totalTransaksi = Order::where('status', 'lunas')->sum('total_price');
        $totalOrder     = Order::count();

        $userTerbaru = User::latest()->take(5)->get();
        $ebookTerbaru = Ebook::with(['seller', 'category'])->latest()->take(5)->get();
        $orderTerbaru = Order::with(['buyer', 'ebook'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPembeli', 'totalPenjual', 'totalEbook',
            'totalTransaksi', 'totalOrder',
            'userTerbaru', 'ebookTerbaru', 'orderTerbaru'
        ));
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