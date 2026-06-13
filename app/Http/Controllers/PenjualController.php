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
}