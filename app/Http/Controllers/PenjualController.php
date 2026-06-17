<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Order;
use Illuminate\Http\Request;

class PenjualController extends Controller
{
    public function dashboard()
    {
        $totalEbook = Ebook::where('seller_id', auth()->id())->count();

        $totalPenjualan = Order::whereHas('ebook', fn($q) =>
            $q->where('seller_id', auth()->id()))
            ->where('status', 'lunas')->count();

        $totalPending = Order::whereHas('ebook', fn($q) =>
            $q->where('seller_id', auth()->id()))
            ->where('status', 'pending')->count();

        $totalPendapatan = Order::whereHas('ebook', fn($q) =>
            $q->where('seller_id', auth()->id()))
            ->where('status', 'lunas')->sum('total_price');

        $orderTerbaru = Order::whereHas('ebook', fn($q) =>
            $q->where('seller_id', auth()->id()))
            ->with(['ebook', 'buyer'])
            ->latest()->take(5)->get();

        return view('penjual.dashboard', compact(
            'totalEbook', 'totalPenjualan', 'totalPending',
            'totalPendapatan', 'orderTerbaru'
        ));
    }

    public function penjualan()
    {
        $orders = Order::whereHas('ebook', fn($q) =>
            $q->where('seller_id', auth()->id()))
            ->with(['ebook', 'buyer'])
            ->latest()->paginate(15);

        return view('penjual.penjualan', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        abort_if($order->ebook->seller_id !== auth()->id(), 403);

        $request->validate([
            'status' => 'required|in:lunas,ditolak'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status order berhasil diperbarui!');
    }

    public function laporan(Request $request)
    {
        $query = Order::whereHas('ebook', fn($q) =>
            $q->where('seller_id', auth()->id()))
            ->where('status', 'lunas')
            ->with(['ebook', 'buyer']);

        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }
        if ($request->tahun) {
            $query->whereYear('created_at', $request->tahun);
        }

        $totalPendapatan = (clone $query)->sum('total_price');
        $orders = $query->latest()->paginate(15);

        return view('penjual.laporan', compact('orders', 'totalPendapatan'));
    }
    
    public function library()
    {
        $ebooks = Ebook::where('seller_id', auth()->id())
                    ->withCount('orders')
                    ->latest()
                    ->get();

        $totalSales = Order::whereHas('ebook', fn($q) => $q->where('seller_id', auth()->id()))
                        ->where('status', 'completed')
                        ->whereMonth('created_at', now()->month)
                        ->sum('total_price');            // ← fix

        $activeReaders = $ebooks->where('status', 'aktif')->count();

        $avgRating = \App\Models\Review::whereHas('ebook', fn($q) => $q->where('seller_id', auth()->id()))
                                    ->avg('rating') ?? 0;

        return view('penjual.library', compact('ebooks', 'totalSales', 'activeReaders', 'avgRating'));
    }

    public function inventory()
    {
        $ebooks = Ebook::where('seller_id', auth()->id())
                    ->with('category')
                    ->withCount('orders')
                    ->latest()
                    ->paginate(10);

        $totalEbooks      = Ebook::where('seller_id', auth()->id())->count();
        $activeListings   = Ebook::where('seller_id', auth()->id())->where('status', 'aktif')->count();
        $lowStockAlerts   = Ebook::where('seller_id', auth()->id())->where('status', 'nonaktif')->count();
        $monthlyRoyalties = Order::whereHas('ebook', fn($q) => $q->where('seller_id', auth()->id()))
                                ->where('status', 'completed')
                                ->whereMonth('created_at', now()->month)
                                ->sum('total_price') * 0.7;   // ← fix

        return view('penjual.inventory', compact(
            'ebooks', 'totalEbooks', 'activeListings', 'lowStockAlerts', 'monthlyRoyalties'
        ));
    }

    public function sales()
    {
        $orders = Order::whereHas('ebook', fn($q) => $q->where('seller_id', auth()->id()))
                        ->with(['ebook', 'buyer'])   // ← ganti 'user' → 'buyer'
                        ->latest()
                        ->paginate(15);

        $orders = Order::whereHas('ebook', fn($q) => $q->where('seller_id', auth()->id()))
                    ->with(['ebook', 'buyer'])
                    ->latest()
                    ->paginate(15);

        $totalOrdersToday = Order::whereHas('ebook', fn($q) => $q->where('seller_id', auth()->id()))
                                ->whereDate('created_at', today())
                                ->count();

        $dailyRevenue = Order::whereHas('ebook', fn($q) => $q->where('seller_id', auth()->id()))
                            ->where('status', 'completed')
                            ->whereDate('created_at', today())
                            ->sum('total_price');

        $completedOrders = Order::whereHas('ebook', fn($q) => $q->where('seller_id', auth()->id()))
                                ->where('status', 'completed')
                                ->whereMonth('created_at', now()->month)
                                ->count();

        $pendingOrders = Order::whereHas('ebook', fn($q) => $q->where('seller_id', auth()->id()))
                            ->where('status', 'pending')
                            ->count();

        return view('penjual.penjualan', compact(
            'orders', 'totalOrdersToday', 'dailyRevenue', 'completedOrders', 'pendingOrders'
        ));
    }
}