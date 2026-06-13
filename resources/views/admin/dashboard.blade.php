@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<h4 class="fw-bold mb-1">Dashboard Admin</h4>
<p class="text-muted mb-4">Pantau keseluruhan sistem EbookStore</p>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3" style="border-top:3px solid #e94560!important">
            <div class="fs-2 fw-bold text-danger">{{ $totalPembeli }}</div>
            <div class="text-muted small">Total Pembeli</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3" style="border-top:3px solid #6366f1!important">
            <div class="fs-2 fw-bold" style="color:#6366f1">{{ $totalPenjual }}</div>
            <div class="text-muted small">Total Penjual</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3" style="border-top:3px solid #10b981!important">
            <div class="fs-2 fw-bold text-success">{{ $totalEbook }}</div>
            <div class="text-muted small">Total Ebook</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3" style="border-top:3px solid #f5a623!important">
            <div class="fs-5 fw-bold text-warning">Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</div>
            <div class="text-muted small">Total Transaksi</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- User Terbaru --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between">
                <span>User Terdaftar Terbaru</span>
                <a href="{{ route('admin.user.index') }}" class="text-decoration-none small text-danger">Lihat semua →</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>Nama</th><th>Role</th><th>Bergabung</th></tr>
                    </thead>
                    <tbody>
                        @foreach($userTerbaru as $user)
                        <tr>
                            <td>
                                <div class="fw-semibold small">{{ $user->name }}</div>
                                <div class="text-muted" style="font-size:11px">{{ $user->email }}</div>
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($user->role === 'penjual')
                                    <span class="badge" style="background:#ede9fe;color:#5b21b6">Penjual</span>
                                @else
                                    <span class="badge bg-info">Pembeli</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Ebook Terbaru --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Ebook Terbaru Ditambahkan</div>
            <div class="card-body p-0">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>Judul</th><th>Penjual</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @foreach($ebookTerbaru as $ebook)
                        <tr>
                            <td>
                                <div class="fw-semibold small">{{ Str::limit($ebook->title, 30) }}</div>
                                <div class="text-muted" style="font-size:11px">{{ $ebook->category->name }}</div>
                            </td>
                            <td class="small">{{ $ebook->seller->name }}</td>
                            <td>
                                <span class="badge bg-{{ $ebook->status === 'aktif' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($ebook->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Order Terbaru --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between">
                <span>Order Terbaru</span>
                <a href="{{ route('admin.laporan') }}" class="text-decoration-none small text-danger">Lihat laporan →</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>Pembeli</th><th>Ebook</th><th>Harga</th><th>Tanggal</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($orderTerbaru as $order)
                        <tr>
                            <td>{{ $order->buyer->name }}</td>
                            <td>{{ Str::limit($order->ebook->title, 35) }}</td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
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
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada order</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection