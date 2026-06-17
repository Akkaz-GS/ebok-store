@extends('layouts.seller')

@section('title', 'Inventory')
@section('page-title', 'Ebook Seller Portal')
@section('search-placeholder', 'Search inventory...')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="fw-bold mb-0" style="font-size:1.25rem;">Inventory Management</h4>
        <p class="text-muted mb-0" style="font-size:.8rem;">Manage your digital publishing catalog and track real-time listings.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn-outline-custom"><i class="bi bi-funnel"></i> Filter</button>
        <a href="#" class="btn-outline-custom"><i class="bi bi-download"></i> Export CSV</a>
    </div>
</div>

{{-- Inventory Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <p class="stat-label">Total Ebooks</p>
            <div class="stat-value">{{ $totalEbooks ?? 0 }}</div>
            <div class="stat-change text-up"><i class="bi bi-arrow-up-short"></i>+12% this month</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <p class="stat-label">Active Listings</p>
            <div class="stat-value">{{ $activeListings ?? 0 }}</div>
            <div class="stat-change text-muted" style="font-size:.73rem;">
                {{ $totalEbooks > 0 ? round(($activeListings/$totalEbooks)*100) : 0 }}% of total catalog
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <p class="stat-label">Low Stock Alerts</p>
            <div class="stat-value" style="color:#d97706;">{{ $lowStockAlerts ?? 0 }}</div>
            <div class="stat-change" style="color:#d97706;font-size:.73rem;">
                <i class="bi bi-exclamation-triangle"></i> Needs attention
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <p class="stat-label">Monthly Royalties</p>
            <div class="stat-value" style="color:var(--primary);">
                Rp {{ number_format($monthlyRoyalties ?? 0, 0, ',', '.') }}
            </div>
            <div class="stat-change text-up"><i class="bi bi-arrow-up-short"></i>+5.4%</div>
        </div>
    </div>
</div>

{{-- Inventory Table --}}
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>BOOK TITLE</th>
                    <th>KATEGORI</th>
                    <th>HARGA</th>
                    <th>STATUS</th>
                    <th class="text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ebooks ?? [] as $ebook)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:36px;height:46px;border-radius:4px;background:linear-gradient(135deg,#c0392b,#922b21);flex-shrink:0;
                                    display:flex;align-items:center;justify-content:center;">
                                    @if($ebook->cover_path)
                                        <img src="{{ asset('storage/'.$ebook->cover_path) }}"
                                             style="width:100%;height:100%;object-fit:cover;border-radius:4px;">
                                    @else
                                        <i class="bi bi-book" style="color:rgba(255,255,255,.6);font-size:.8rem;"></i>
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:.85rem;color:#111;">{{ $ebook->judul }}</div>
                                    <div style="font-size:.73rem;color:#6b7280;">By {{ auth()->user()->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-category badge-technology">{{ $ebook->category->nama ?? 'Umum' }}</span>
                        </td>
                        <td style="font-weight:600;">Rp {{ number_format($ebook->harga, 0, ',', '.') }}</td>
                        <td>
                            @if($ebook->is_active)
                                <span class="badge-status badge-active"><span style="color:#16a34a;margin-right:4px;">⬤</span> Active</span>
                            @else
                                <span class="badge-status badge-inactive"><span style="color:#9ca3af;margin-right:4px;">⬤</span> Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('penjual.ebook.edit', $ebook->id) }}"
                                   class="icon-btn" title="Edit" style="width:30px;height:30px;font-size:.85rem;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('penjual.ebook.toggle', $ebook->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="icon-btn" title="{{ $ebook->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                            style="width:30px;height:30px;font-size:.85rem;background:#fff;border:1px solid var(--border);border-radius:50%;cursor:pointer;color:#6b7280;">
                                        <i class="bi bi-{{ $ebook->is_active ? 'slash-circle' : 'check-circle' }}"></i>
                                    </button>
                                </form>
                                <div class="dropdown">
                                    <button class="icon-btn dropdown-toggle-no-caret" data-bs-toggle="dropdown"
                                            style="width:30px;height:30px;font-size:.85rem;background:#fff;border:1px solid var(--border);border-radius:50%;cursor:pointer;color:#6b7280;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="font-size:.82rem;">
                                        <li><a class="dropdown-item" href="{{ route('penjual.ebook.show', $ebook->id) }}">
                                            <i class="bi bi-eye me-2"></i>View Details</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('penjual.ebook.destroy', $ebook->id) }}" method="POST"
                                                  onsubmit="return confirm('Hapus ebook ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                        Belum ada ebook di inventory.
                        <a href="{{ route('penjual.ebook.create') }}" style="color:var(--primary);">Tambah sekarang →</a>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($ebooks) && $ebooks->hasPages())
        <div class="p-3 d-flex justify-content-between align-items-center border-top">
            <span style="font-size:.8rem;color:#6b7280;">
                Showing {{ $ebooks->firstItem() }} to {{ $ebooks->lastItem() }} of {{ $ebooks->total() }} entries
            </span>
            {{ $ebooks->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
