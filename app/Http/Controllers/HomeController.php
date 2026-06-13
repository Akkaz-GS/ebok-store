<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Ebook::where('status', 'aktif')
                      ->with(['category', 'seller', 'promo']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%')
                  ->orWhereHas('seller', fn($q) =>
                      $q->where('name', 'like', '%'.$request->search.'%')
                  );
            });
        }

        if ($request->category) {
            $query->whereHas('category', fn($q) =>
                $q->where('slug', $request->category)
            );
        }

        $ebooks     = $query->latest()->paginate(8)->withQueryString();
        $categories = Category::withCount('ebooks')->get();

        return view('home.index', compact('ebooks', 'categories'));
    }

    public function kategori(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $ebooks = Ebook::where('status', 'aktif')
                       ->where('category_id', $category->id)
                       ->with(['category', 'seller', 'promo'])
                       ->latest()
                       ->paginate(12);

        return view('home.kategori', compact('ebooks', 'category'));
    }
}