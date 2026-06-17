@extends('layouts.pembeli')

@section('title', 'My Library - EbookStore')

@section('content')

{{--
    CATATAN: Route & method 'pembeli.library' belum ada di web.php / PembeliController.
    Lihat instruksi penambahan route & controller yang diberikan setelah file ini.

    $myEbooks : collection Order (with('ebook.seller'), where status dibayar/selesai)
                -> $order->id, $order->ebook->title, $order->ebook->slug, $order->ebook->cover,
                   $order->ebook->seller->name
--}}

<h2 class="page-title">My Library</h2>
<p class="page-subtitle">Ebook yang sudah kamu beli dan terverifikasi, siap untuk diunduh.</p>

<div class="section-block">
    @forelse ($myEbooks as $order)
        @if ($loop->first)
            <div class="ebook-grid">
        @endif

        <div>
            <a href="{{ route('ebook.show', $order->ebook->slug) }}" class="text-decoration-none">
                <div class="mini-ebook-cover">
                    @if ($order->ebook->cover)
                        <img src="{{ Storage::url($order->ebook->cover) }}" alt="{{ $order->ebook->title }}">
                    @else
                        <div class="placeholder">{{ $order->ebook->title }}</div>
                    @endif
                </div>
                <span class="mini-ebook-title">{{ Str::limit($order->ebook->title, 30) }}</span>
            </a>
            <div class="mini-ebook-author">{{ $order->ebook->seller->name }}</div>
            <a href="{{ route('pembeli.download', $order->id) }}" class="btn-cta-outline w-100 mt-2">
                <i class="bi bi-download"></i> Unduh
            </a>
        </div>

        @if ($loop->last)
            </div>
        @endif
    @empty
        <div class="text-center py-5">
            <i class="bi bi-journal-x fs-1 text-muted"></i>
            <p class="text-muted mt-2 mb-3">Belum ada ebook di library kamu.</p>
            <a href="{{ route('home') }}" class="btn-cta-outline">Jelajahi Ebook</a>
        </div>
    @endforelse
</div>

@endsection