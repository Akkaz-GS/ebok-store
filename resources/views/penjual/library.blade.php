@extends('layouts.seller')

@section('title', 'My Library')
@section('search-placeholder', 'Cari ebook di library...')

@push('styles')
<style>
    .ebook-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 16px;
    }
    .ebook-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--card-radius);
        overflow: hidden;
        transition: box-shadow .2s, transform .15s;
    }
    .ebook-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); transform: translateY(-2px); }

    .ebook-cover {
        height: 190px;
        background: #e5e7eb;
        position: relative;
        overflow: hidden;
    }
    .ebook-cover img { width: 100%; height: 100%; object-fit: cover; }
    .cover-placeholder {
        width: 100%; height: 100%;
        background: linear-gradient(135deg, #2c3347 0%, #1a1f2e 100%);
        display: flex; align-items: center; justify-content: center;
    }
    .cover-placeholder i { font-size: 2.2rem; color: rgba(255,255,255,.25); }

    .ebook-badge {
        position: absolute; top: 8px; right: 8px;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: .66rem; font-weight: 700;
        text-transform: uppercase;
    }
    .badge-bestseller { background: var(--primary); color: #fff; }
    .badge-review     { background: #374151; color: #fff; }
    .badge-draft      { background: rgba(0,0,0,.45); color: #fff; }

    .ebook-body { padding: 12px; }
    .ebook-title { font-size: .87rem; font-weight: 700; color: #111; line-height: 1.3; margin-bottom: 2px; }
    .ebook-price { font-size: .78rem; font-weight: 700; color: var(--primary); margin-bottom: 10px; }

    .ebook-footer {
        display: flex;
        gap: 6px;
        align-items: center;
        justify-content: space-between;
    }
    .ebook-status { font-size: .72rem; font-weight: 600; }

    .ebook-actions { display: flex; gap: 5px; }
    .btn-ebook-sm {
        padding: 5px 10px;
        border-radius: 5px;
        font-size: .76rem;
        font-weight: 600;
        text-decoration: none;
        border: none; cursor: pointer;
        transition: all .15s;
    }
    .btn-ebook-red  { background: var(--primary); color: #fff; }
    .btn-ebook-red:hover  { background: var(--primary-hover); color: #fff; }
    .btn-ebook-gray { background: #f3f4f6; color: #374151; border: 1px solid var(--border); }
    .btn-ebook-gray:hover { background: #e5e7eb; }

    .add-card {
        border: 2px dashed #d1d5db;
        border-radius: var(--card-radius);
        min-height: 260px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        cursor: pointer;
        background: #fafafa;
        text-decoration: none;
        transition: all .2s;
    }
    .add-card:hover { border-color: var(--primary); background: var(--primary-light); }
    .add-card .add-icon {
        width: 44px; height: 44px;
        border-radius: 50%;
        background: #e5e7eb;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; color: #9ca3af;
        margin-bottom: 8px;
        transition: all .2s;
    }
    .add-card:hover .add-icon { background: var(--primary); color: #fff; }
</style>
@endpush

@section('content')
<div class="page-header d-flex align-items-start justify-content-between">
    <div>
        <h4>My Library</h4>
        <p>Kelola semua ebook yang kamu publikasikan</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn-outline-gray"><i class="bi bi-funnel"></i> Filter</button>
        <button class="btn-outline-gray"><i class="bi bi-sort-down"></i> Urutkan</button>
    </div>
</div>

{{-- Mini stats --}}
<div class="row g-3 mb-4">
    <div class="col-4">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-pink"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-label">Penjualan Bulan Ini</div>
            <div class="stat-value" style="font-size:1.25rem;">Rp {{ number_format($totalSales ?? 0, 0, ',', '.') }}</div>
            <div class="stat-change text-up mt-1">+12%</div>
        </div>
    </div>
    <div class="col-4">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-blue"><i class="bi bi-people"></i></div>
            <div class="stat-label">Ebook Aktif</div>
            <div class="stat-value" style="font-size:1.25rem;">{{ number_format($activeReaders ?? 0) }}</div>
            <div class="stat-change" style="color:#6b7280;font-size:.72rem;">judul dipublikasikan</div>
        </div>
    </div>
    <div class="col-4">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-yellow"><i class="bi bi-star"></i></div>
            <div class="stat-label">Rating Rata-rata</div>
            <div class="stat-value" style="font-size:1.25rem;">{{ number_format($avgRating ?? 0, 1) }}</div>
            <div class="stat-change" style="color:#6b7280;font-size:.72rem;">dari 5.0</div>
        </div>
    </div>
</div>

{{-- Grid --}}
<div class="ebook-grid">
    @forelse($ebooks ?? [] as $ebook)
        <div class="ebook-card">
            <div class="ebook-cover">
                @if($ebook->cover)
                    <img src="{{ asset('storage/'.$ebook->cover) }}" alt="{{ $ebook->title }}">
                @else
                    <div class="cover-placeholder"><i class="bi bi-book"></i></div>
                @endif

                @if(($ebook->orders_count ?? 0) > 10)
                    <span class="ebook-badge badge-bestseller">Bestseller</span>
                @elseif($ebook->status === 'nonaktif')
                    <span class="ebook-badge badge-draft">Nonaktif</span>
                @endif
            </div>
            <div class="ebook-body">
                <div class="ebook-title">{{ Str::limit($ebook->title, 40) }}</div>
                <div class="ebook-price">Rp {{ number_format($ebook->price, 0, ',', '.') }}</div>
                <div class="ebook-footer">
                    <div>
                        @if($ebook->status === 'aktif')
                            <span class="ebook-status" style="color:#16a34a;">⬤ Aktif</span>
                        @else
                            <span class="ebook-status" style="color:#9ca3af;">⬤ Nonaktif</span>
                        @endif
                    </div>
                    <div class="ebook-actions">
                        <a href="{{ route('penjual.ebook.edit', $ebook->id) }}"
                           class="btn-ebook-sm btn-ebook-red">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse

    {{-- Add new --}}
    <a href="{{ route('penjual.ebook.create') }}" class="add-card">
        <div class="add-icon"><i class="bi bi-plus-lg"></i></div>
        <div style="font-size:.85rem;font-weight:600;color:#374151;">Tambah Ebook</div>
        <div style="font-size:.73rem;color:#9ca3af;margin-top:3px;text-align:center;">
            Upload atau buat draft baru
        </div>
    </a>
</div>
@endsection