<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ebook;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   // OrderController
    public function index()
    {
        $userId = auth()->id();

        $orders = Order::with('ebook.seller')->where('buyer_id', $userId)->latest()->paginate(10);

        $totalSpent = Order::where('buyer_id', $userId)
            ->whereIn('status', ['dibayar', 'selesai'])->sum('total_price');

        $pendingCount = Order::where('buyer_id', $userId)->where('status', 'menunggu_verifikasi')->count();
        $completedCount = Order::where('buyer_id', $userId)->whereIn('status', ['dibayar', 'selesai'])->count();

        return view('pembeli.riwayat', compact('orders', 'totalSpent', 'pendingCount', 'completedCount'));
    }
    
    // Proses beli ebook
    public function store(Request $request, Ebook $ebook)
    {
        // Cek ebook aktif
        abort_if($ebook->status !== 'aktif', 404);

        // Cek sudah pernah beli
        $sudahBeli = Order::where('buyer_id', auth()->id())
                          ->where('ebook_id', $ebook->id)
                          ->whereIn('status', ['pending', 'lunas'])
                          ->exists();

        if ($sudahBeli) {
            return back()->with('error', 'Kamu sudah membeli atau sedang memproses ebook ini.');
        }

        // Hitung harga final
        $harga = $ebook->promo ? $ebook->final_price : $ebook->price;

        Order::create([
            'buyer_id'    => auth()->id(),
            'ebook_id'    => $ebook->id,
            'total_price' => $harga,
            'status'      => 'pending',
        ]);

        return redirect()->route('pembeli.order.index')
                         ->with('success', 'Pesanan berhasil dibuat! Silakan upload bukti pembayaran.');
    }

    // Upload bukti pembayaran
    public function uploadBukti(Request $request, Order $order)
    {
        abort_if($order->buyer_id !== auth()->id(), 403);
        abort_if($order->status !== 'pending', 403);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $order->update(['payment_proof' => $path]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi penjual.');
    }
}