<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Ebook;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Ebook $ebook)
    {
        // Pastikan sudah beli dan lunas
        $sudahBeli = Order::where('buyer_id', auth()->id())
                          ->where('ebook_id', $ebook->id)
                          ->where('status', 'lunas')
                          ->exists();

        if (!$sudahBeli) {
            return back()->with('error', 'Kamu harus membeli ebook ini sebelum memberi ulasan.');
        }

        // Cek sudah pernah review
        $sudahReview = Review::where('buyer_id', auth()->id())
                             ->where('ebook_id', $ebook->id)
                             ->exists();

        if ($sudahReview) {
            return back()->with('error', 'Kamu sudah memberikan ulasan untuk ebook ini.');
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'ebook_id' => $ebook->id,
            'buyer_id' => auth()->id(),
            'rating'   => $request->rating,
            'comment'  => $request->comment,
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }
}