<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Ebook::query()->where('status', 'aktif');

        // Filter pencarian: judul, penulis, atau nama kategori
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($cat) use ($search) {
                      $cat->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter kategori berdasarkan slug (diklik dari kartu kategori)
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $ebooks = $query->latest()->paginate(8)->withQueryString();

        $categories = Category::withCount('ebooks')->get();

        return view('home.index', compact('ebooks', 'categories'));
    }
}