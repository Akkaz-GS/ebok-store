@extends('layouts.seller')

@section('title', 'Dashboard')
@section('search-placeholder', 'Cari ebook, pesanan, atau laporan...')

@push('styles')
<style>
    .chart-bars {
        display: flex;
        align-items: flex-end;
        gap: 6px;
        height: 120px;
        padding-bottom: 2px;
    }
    .chart-bar {
        flex: 1;
        background: #fce4e4;
        border-radius: 3px 3px 0 0;
        min-height: 4px;
        transition: background .15s;
        cursor: pointer;
    }
    .chart-bar:hover { background: var(--primary); }
    .chart-bar.current { background: var(--primary); }
    .chart-labels {
        display: flex;
        gap: 6px;
        margin-top: 6px;
    }
    .chart-labels span {
        flex: 1;
        text-align: center;
        font-size: .65rem;
        color: #9ca3af;
    }

    .product-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
    }
    .product-row:last-child { border-bottom: none; }
    .product-cover {
        width: 38px; height: 50px;
        border-radius: 4px;
        background: linear-gradient(135deg, #2c3347, #1a1f2e);
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
    }
    .product-cover img { width: 100%; height: 100%; object-fit: cover; }
    .product-cover i { color: rgba(255,255,255,.3); font-size: .85rem; }
</style>
@endpush

@section('content')
<div class="page-header d-flex align-items-start justify-content-between">
    <div>
        <h4>Ringkasan Performa</h4>
        <p>Update terakhir: Hari ini, {{ now()->format('H:i') }} WIB</p>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-pink"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-change text-up">+12.5%</div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value" style="font-size:1.35rem;">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-blue"><i class="bi bi-book"></i></div>
            <div class="stat-change text-up">+5.2%</div>
            <div class="stat-label">Ebook Terjual</div>
            <div class="stat-value">{{ number_format($ebookTerjual ?? 0) }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-yellow"><i class="bi bi-star"></i></div>
            <div class="stat-change" style="color:#6b7280;">Stabil</div>
            <div class="stat-label">Rating Rata-rata</div>
            <div class="stat-value">{{ number_format($avgRating ?? 0, 1) }}<span style="font-size:.9rem;color:#6b7280;font-weight:500;"> / 5.0</span></div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-green"><i class="bi bi-collection"></i></div>
            <div class="stat-change">
                <a href="{{ route('penjual.library') }}" class="link-red">Kelola →</a>
            </div>
            <div class="stat-label">Produk Aktif</div>
            <div class="stat-value">{{ $produkAktif ?? 0 }}<span style="font-size:.85rem;color:#6b7280;font-weight:500;"> judul</span></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Chart --}}
    <div class="col-lg-8">
        <div class="content-card h-100">
            <div class="content-card-header">
                <div>
                    <h5>Statistik Penjualan Bulanan</h5>
                    <p class="sub">Total volume penjualan per bulan tahun {{ date('Y') }}</p>
                </div>
                <select class="form-select form-select-sm" style="width:auto;font-size:.78rem;border-color:var(--border);">
                    <option>Tahun {{ date('Y') }}</option>
                    <option>Tahun {{ date('Y')-1 }}</option>
                </select>
            </div>
            <div class="p-4">
                @php
                    $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                    $data   = $monthlySales ?? array_fill(0, 12, 0);
                    $maxVal = max($data) ?: 1;
                    $curMon = (int)date('n') - 1;
                @endphp
                <div class="chart-bars">
                    @foreach($data as $i => $v)
                        <div class="chart-bar {{ $i === $curMon ? 'current' : '' }}"
                             style="height:{{ max(round(($v/$maxVal)*100), 3) }}%"
                             title="{{ $months[$i] }}: {{ $v }}"></div>
                    @endforeach
                </div>
                <div class="chart-labels">
                    @foreach($months as $m)<span>{{ $m }}</span>@endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="col-lg-4">
        <div class="content-card h-100">
            <div class="content-card-header">
                <h5>Produk Terlaris</h5>
                <a href="{{ route('penjual.library') }}" class="link-red">Lihat Semua →</a>
            </div>
            <div class="px-4 py-2">
                @forelse($produkTerlaris ?? [] as $ebook)
                    <div class="product-row">
                        <div class="product-cover">
                            @if($ebook->cover)
                                <img src="{{ asset('storage/'.$ebook->cover) }}" alt="">
                            @else
                                <i class="bi bi-book"></i>
                            @endif
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:.83rem;font-weight:600;color:#111;
                                        white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $ebook->title }}
                            </div>
                            <div style="font-size:.73rem;color:#6b7280;">Terjual {{ $ebook->orders_count ?? 0 }} eks</div>
                            <div style="font-size:.78rem;font-weight:700;color:var(--primary);">
                                Rp {{ number_format($ebook->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted py-4" style="font-size:.82rem;">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Aktivitas Terbaru --}}
<div class="content-card">
    <div class="content-card-header">
        <div>
            <h5>Aktivitas Terbaru</h5>
            <p class="sub">Riwayat penjualan dan pesanan pelanggan</p>
        </div>
        <a href="{{ route('penjual.sales') }}" class="link-red">Lihat Semua →</a>
    </div>
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>ID PESANAN</th>
                    <th>JUDUL EBOOK</th>
                    <th>PEMBELI</th>
                    <th>TANGGAL</th>
                    <th>STATUS</th>
                    <th class="text-end">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders ?? [] as $order)
                    <tr>
                        <td style="color:var(--primary);font-weight:600;">
                            #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td>{{ Str::limit($order->ebook->title ?? '-', 30) }}</td>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td style="color:#6b7280;">
                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                        </td>
                        <td>
                            @php $st = $order->status; @endphp
                            @if($st === 'completed' || $st === 'lunas')
                                <span class="badge-pill badge-selesai">Selesai</span>
                            @elseif($st === 'pending')
                                <span class="badge-pill badge-pending">Menunggu</span>
                            @else
                                <span class="badge-pill badge-ditolak">Ditolak</span>
                            @endif
                        </td>
                        <td class="text-end fw-semibold">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4" style="font-size:.83rem;">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
