@extends('layouts.penjual')
@section('title', 'Laporan Penjualan')

@section('content')
<h4 class="fw-bold mb-1">Laporan Penjualan</h4>
<p class="text-muted mb-4">Rekap transaksi yang sudah lunas</p>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Bulan</label>
                <select name="bulan" class="form-select">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1, 12) as $b)
                        <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Tahun</label>
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach(range(date('Y'), 2024) as $t)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-danger w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

{{-- Total --}}
<div class="alert border-0 shadow-sm mb-4" style="background:#fff">
    <span class="fw-semibold">Total Pendapatan: </span>
    <span class="fw-bold text-danger fs-5">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Pembeli</th>
                    <th>Email</th>
                    <th>Ebook</th>
                    <th>Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->buyer->name }}</td>
                <td class="text-muted small">{{ $order->buyer->email }}</td>
                <td>{{ $order->ebook->title }}</td>
                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5 text-muted">Belum ada data penjualan</td>
            </tr>
            @endforelse
        </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $orders->links() }}</div>
@endsection 