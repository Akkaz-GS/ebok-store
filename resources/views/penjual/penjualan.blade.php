@extends('layouts.seller')

@section('title', 'Sales Tracking')
@section('search-placeholder', 'Cari pesanan...')

@push('styles')
<style>
    .hourly-bars { display:flex; align-items:flex-end; gap:5px; height:100px; }
    .hourly-bar  {
        flex:1; border-radius:3px 3px 0 0; min-height:3px;
        background:#fce4e4; cursor:pointer; transition:background .15s;
    }
    .hourly-bar:hover, .hourly-bar.peak { background:var(--primary); }
    .hourly-labels { display:flex; gap:5px; margin-top:5px; }
    .hourly-labels span { flex:1; text-align:center; font-size:.63rem; color:#9ca3af; }
</style>
@endpush

@section('content')
<div class="page-header d-flex align-items-start justify-content-between">
    <div>
        <h4>Sales Tracking</h4>
        <p>Pantau semua pesanan dan aktivitas penjualan kamu</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn-outline-gray"><i class="bi bi-funnel"></i> Filter</button>
        <button class="btn-outline-gray"><i class="bi bi-download"></i> Export</button>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-pink"><i class="bi bi-cart3"></i></div>
            <div class="stat-change text-up">+12% dari kemarin</div>
            <div class="stat-label">Total Pesanan Hari Ini</div>
            <div class="stat-value">{{ $totalOrdersToday ?? 0 }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-blue"><i class="bi bi-wallet2"></i></div>
            <div class="stat-change text-up">+8.4% dari kemarin</div>
            <div class="stat-label">Pendapatan Hari Ini</div>
            <div class="stat-value" style="font-size:1.25rem;">
                Rp {{ number_format($dailyRevenue ?? 0, 0, ',', '.') }}
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-green"><i class="bi bi-check-circle"></i></div>
            <div class="stat-change" style="color:#6b7280;font-size:.72rem;">transaksi selesai</div>
            <div class="stat-label">Pesanan Selesai</div>
            <div class="stat-value">{{ $completedOrders ?? 0 }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-yellow"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-change" style="color:#d97706;font-size:.72rem;">perlu dikonfirmasi</div>
            <div class="stat-label">Menunggu Verifikasi</div>
            <div class="stat-value">{{ $pendingOrders ?? 0 }}</div>
        </div>
    </div>
</div>

{{-- Orders Table --}}
<div class="content-card mb-4">
    <div class="content-card-header">
        <h5>Daftar Pesanan</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>ID PESANAN</th>
                    <th>PEMBELI</th>
                    <th>EBOOK</th>
                    <th>TANGGAL</th>
                    <th>STATUS</th>
                    <th class="text-end">TOTAL</th>
                    <th class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders ?? [] as $order)
                    <tr>
                        <td style="color:var(--primary);font-weight:600;">
                            #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:.83rem;">{{ $order->buyer->name ?? '-' }}</div>
                            <div style="font-size:.72rem;color:#6b7280;">{{ $order->buyer->email ?? '' }}</div>
                        </td>
                        <td style="font-size:.83rem;">{{ Str::limit($order->ebook->title ?? '-', 28) }}</td>
                        <td style="color:#6b7280;font-size:.82rem;">
                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                        </td>
                        <td>
                            @php $st = $order->status; @endphp
                            @if(in_array($st, ['completed','lunas']))
                                <span class="badge-pill badge-selesai">Selesai</span>
                            @elseif($st === 'pending')
                                <span class="badge-pill badge-pending">Menunggu</span>
                            @else
                                <span class="badge-pill badge-ditolak">Ditolak</span>
                            @endif
                        </td>
                        <td class="text-end fw-semibold" style="font-size:.84rem;">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @if($order->status === 'pending')
                                <form action="{{ route('penjual.order.status', $order->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn-primary-red"
                                            style="padding:4px 10px;font-size:.75rem;">
                                        <i class="bi bi-check-lg"></i> Konfirmasi
                                    </button>
                                </form>
                            @else
                                <span style="font-size:.75rem;color:#9ca3af;">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;color:#d1d5db;"></i>
                            Belum ada pesanan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($orders) && method_exists($orders, 'hasPages') && $orders->hasPages())
        <div class="p-3 d-flex justify-content-between align-items-center border-top">
            <span style="font-size:.78rem;color:#6b7280;">
                Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }}
            </span>
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

{{-- Hourly Chart --}}
<div class="content-card">
    <div class="content-card-header">
        <h5>Aktivitas Penjualan per Jam</h5>
        <select class="form-select form-select-sm" style="width:auto;font-size:.78rem;">
            <option>Hari ini</option>
            <option>Kemarin</option>
        </select>
    </div>
    <div class="p-4">
        @php
            $hours = ['8','9','10','11','12','13','14','15','16','17'];
            $hData = $hourlyData ?? [3,8,15,20,32,38,30,22,12,6];
            $maxH  = max($hData) ?: 1;
            $peakI = array_search(max($hData), $hData);
        @endphp
        <div class="hourly-bars">
            @foreach($hData as $i => $v)
                <div class="hourly-bar {{ $i === $peakI ? 'peak' : '' }}"
                     style="height:{{ max(round(($v/$maxH)*100), 3) }}%"
                     title="{{ $hours[$i] }}:00 — {{ $v }} pesanan"></div>
            @endforeach
        </div>
        <div class="hourly-labels">
            @foreach($hours as $h)<span>{{ $h }}:00</span>@endforeach
        </div>
    </div>
</div>
@endsection
