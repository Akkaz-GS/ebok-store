@extends('layouts.seller')

@section('title', 'Inventory')
@section('search-placeholder', 'Cari ebook di inventory...')

@section('content')
<div class="page-header d-flex align-items-start justify-content-between">
    <div>
        <h4>Inventory</h4>
        <p>Kelola katalog ebook dan status listing kamu</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn-outline-gray"><i class="bi bi-funnel"></i> Filter</button>
        <a href="{{ route('penjual.ebook.create') }}" class="btn-primary-red">
            <i class="bi bi-plus-lg"></i> Tambah Ebook
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-blue"><i class="bi bi-collection"></i></div>
            <div class="stat-change text-up">+12% bulan ini</div>
            <div class="stat-label">Total Ebook</div>
            <div class="stat-value">{{ $totalEbooks ?? 0 }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-green"><i class="bi bi-check-circle"></i></div>
            <div class="stat-change" style="color:#6b7280;font-size:.72rem;">
                {{ $totalEbooks > 0 ? round((($activeListings ?? 0)/$totalEbooks)*100) : 0 }}% dari total
            </div>
            <div class="stat-label">Listing Aktif</div>
            <div class="stat-value">{{ $activeListings ?? 0 }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-yellow"><i class="bi bi-exclamation-triangle"></i></div>
            <div class="stat-change" style="color:#d97706;font-size:.72rem;">Perlu perhatian</div>
            <div class="stat-label">Nonaktif</div>
            <div class="stat-value">{{ $lowStockAlerts ?? 0 }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-red"><i class="bi bi-wallet2"></i></div>
            <div class="stat-change text-up">+5.4%</div>
            <div class="stat-label">Royalti Bulan Ini</div>
            <div class="stat-value" style="font-size:1.25rem;">
                Rp {{ number_format($monthlyRoyalties ?? 0, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>JUDUL EBOOK</th>
                    <th>KATEGORI</th>
                    <th>HARGA</th>
                    <th>STATUS</th>
                    <th class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ebooks ?? [] as $ebook)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:34px;height:44px;border-radius:4px;overflow:hidden;
                                            background:linear-gradient(135deg,#2c3347,#1a1f2e);
                                            flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                                    @if($ebook->cover)
                                        <img src="{{ asset('storage/'.$ebook->cover) }}"
                                             style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        <i class="bi bi-book" style="color:rgba(255,255,255,.3);font-size:.75rem;"></i>
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:.84rem;color:#111;">
                                        {{ Str::limit($ebook->title, 35) }}
                                    </div>
                                    <div style="font-size:.72rem;color:#6b7280;">
                                        {{ $ebook->orders_count ?? 0 }} terjual
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="background:#dbeafe;color:#1e40af;padding:3px 8px;
                                         border-radius:4px;font-size:.7rem;font-weight:600;">
                                {{ $ebook->category->nama ?? 'Umum' }}
                            </span>
                        </td>
                        <td style="font-weight:600;font-size:.84rem;">
                            Rp {{ number_format($ebook->price, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($ebook->status === 'aktif')
                                <span class="badge-pill badge-aktif">Aktif</span>
                            @else
                                <span class="badge-pill badge-nonaktif">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('penjual.ebook.edit', $ebook->id) }}"
                                   class="btn-outline-gray" style="padding:5px 10px;font-size:.78rem;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <div class="dropdown">
                                    <button class="btn-outline-gray dropdown-toggle-no-arrow"
                                            data-bs-toggle="dropdown"
                                            style="padding:5px 10px;font-size:.78rem;">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="font-size:.82rem;">
                                        <li>
                                            <form action="{{ route('penjual.ebook.toggle', $ebook->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-{{ $ebook->status === 'aktif' ? 'slash-circle' : 'check-circle' }} me-2"></i>
                                                    {{ $ebook->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('penjual.ebook.destroy', $ebook->id) }}" method="POST"
                                                  onsubmit="return confirm('Hapus ebook ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i>Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;color:#d1d5db;"></i>
                            Belum ada ebook.
                            <a href="{{ route('penjual.ebook.create') }}" class="link-red">Tambah sekarang →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($ebooks) && method_exists($ebooks, 'hasPages') && $ebooks->hasPages())
        <div class="p-3 d-flex justify-content-between align-items-center border-top">
            <span style="font-size:.78rem;color:#6b7280;">
                Menampilkan {{ $ebooks->firstItem() }}–{{ $ebooks->lastItem() }} dari {{ $ebooks->total() }} ebook
            </span>
            {{ $ebooks->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
