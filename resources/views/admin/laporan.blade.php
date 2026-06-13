@extends('layouts.admin')
@section('title', 'Laporan')

@section('content')
<h4 class="fw-bold mb-1">Laporan Transaksi</h4>
<p class="text-muted mb-4">Rekap seluruh transaksi platform</p>

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
            <div class="col-md-2">
                <button class="btn btn-danger w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 text-center">
            <div class="fs-4 fw-bold text-danger">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            <div class="text-muted small">Total Pendapatan</div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold small">Penjualan per Kategori</div>
            <div class="card-body p-0">
                <table class="table mb-0 table-sm align-middle">
                    <thead class="table-light">
                        <tr><th>Kategori</th><th>Terjual</th><th>Pendapatan</th></tr>
                    </thead>
                    <tbody>
                        @forelse($perKategori as $k)
                        <tr>
                            <td>{{ $k->name }}</td>
                            <td><span class="badge bg-primary">{{ $k->total }}</span></td>
                            <td>Rp {{ number_format($k->pendapatan, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Detail Transaksi</div>
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Pembeli</th><th>Ebook</th><th>Penjual</th><th>Harga</th><th>Tanggal</th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->buyer->name }}</td>
                    <td>{{ Str::limit($order->ebook->title, 30) }}</td>
                    <td>{{ $order->ebook->seller->name }}</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $orders->links() }}</div>
@endsection