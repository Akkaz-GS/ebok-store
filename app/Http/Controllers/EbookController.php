<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::where('seller_id', auth()->id())
                       ->with('category')
                       ->latest()
                       ->paginate(10);

        return view('penjual.ebook.index', compact('ebooks'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('penjual.ebook.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file'        => 'required|mimes:pdf|max:51200',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $filePath = $request->file('file')->store('ebooks', 'private');

        Ebook::create([
            'seller_id'   => auth()->id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'price'       => $request->price,
            'cover'       => $coverPath,
            'file'        => $filePath,
            'status'      => $request->status,
        ]);

        return redirect()->route('penjual.ebook.index')
                         ->with('success', 'Ebook berhasil ditambahkan!');
    }

    public function edit(Ebook $ebook)
    {
        abort_if($ebook->seller_id !== auth()->id(), 403);
        $categories = Category::all();
        return view('penjual.ebook.edit', compact('ebook', 'categories'));
    }

    public function update(Request $request, Ebook $ebook)
    {
        abort_if($ebook->seller_id !== auth()->id(), 403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file'        => 'nullable|mimes:pdf|max:51200',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        if ($request->hasFile('cover')) {
            if ($ebook->cover) Storage::disk('public')->delete($ebook->cover);
            $ebook->cover = $request->file('cover')->store('covers', 'public');
        }

        if ($request->hasFile('file')) {
            Storage::disk('private')->delete($ebook->file);
            $ebook->file = $request->file('file')->store('ebooks', 'private');
        }

        $ebook->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'price'       => $request->price,
            'cover'       => $ebook->cover,
            'file'        => $ebook->file,
            'status'      => $request->status,
        ]);

        return redirect()->route('penjual.ebook.index')
                         ->with('success', 'Ebook berhasil diperbarui!');
    }

    public function destroy(Ebook $ebook)
    {
        abort_if($ebook->seller_id !== auth()->id(), 403);

        if ($ebook->cover) Storage::disk('public')->delete($ebook->cover);
        Storage::disk('private')->delete($ebook->file);
        $ebook->delete();

        return redirect()->route('penjual.ebook.index')
                         ->with('success', 'Ebook berhasil dihapus!');
    }

    public function show(string $slug)
    {
        $ebook = Ebook::where('slug', $slug)
                      ->where('status', 'aktif')
                      ->with(['category', 'seller', 'reviews.buyer', 'promo'])
                      ->firstOrFail();

        $sudahBeli = false;
        if (auth()->check()) {
            $sudahBeli = Order::where('buyer_id', auth()->id())
                              ->where('ebook_id', $ebook->id)
                              ->where('status', 'lunas')
                              ->exists();
        }

        return view('ebook.show', compact('ebook', 'sudahBeli'));
    }
}