@extends('layouts.penjual')
@section('title', 'Dashboard Penjual')

@section('content')
<h4 class="fw-bold mb-1">Dashboard Penjual</h4>
<p class="text-muted mb-4">Selamat datang, {{ auth()->user()->name }}!</p>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="fs-2 fw-bold text-primary">{{ $totalEbook }}</div>
            <div class="text-muted small">Total Ebook</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="fs-2 fw-bold text-success">{{ $totalPenjualan }}</div>
            <div class="text-muted small">Terjual</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="fs-2 fw-bold text-warning">{{ $totalPending }}</div>
            <div class="text-muted small">Order Pending</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="fs-5 fw-bold text-danger">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            <div class="text-muted small">Total Pendapatan</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold d-flex justify-content-between">
        <span>Order Terbaru</span>
        <a href="{{ route('penjual.penjualan') }}" class="text-decoration-none small text-danger">Lihat semua →</a>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Pembeli</th>
                    <th>Ebook</th>
                    <th>Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orderTerbaru as $order)
                <tr>
                    <td>{{ $order->buyer->name }}</td>
                    <td>{{ $order->ebook->title }}</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>
                        @if($order->status === 'lunas')
                            <span class="badge bg-success">Lunas</span>
                        @elseif($order->status === 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada order</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection