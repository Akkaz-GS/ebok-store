@extends('layouts.pembeli')
@section('title', 'Dashboard Pembeli')

@section('content')
<h4 class="fw-bold mb-1">Halo, {{ auth()->user()->name }}! 👋</h4>
<p class="text-muted mb-4">Selamat datang kembali di EbookStore</p>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="fs-2 fw-bold text-primary">{{ $totalBeli }}</div>
            <div class="text-muted small">Total Pembelian</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="fs-2 fw-bold text-success">{{ $totalLunas }}</div>
            <div class="text-muted small">Sudah Lunas</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="fs-2 fw-bold text-warning">{{ $totalPending }}</div>
            <div class="text-muted small">Menunggu Konfirmasi</div>
        </div>
    </div>
</div>

{{-- Order Terbaru --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-semibold d-flex justify-content-between">
        <span>Pembelian Terbaru</span>
        <a href="{{ route('pembeli.order.index') }}" class="text-decoration-none small text-danger">Lihat semua →</a>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Ebook</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orderTerbaru as $order)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $order->ebook->title }}</div>
                        <div class="text-muted small">{{ $order->ebook->category->name }}</div>
                    </td>
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
                    <td>
                        @if($order->status === 'lunas')
                            <a href="{{ route('pembeli.download', $order) }}"
                               class="btn btn-sm btn-success">
                                <i class="bi bi-download"></i> Unduh
                            </a>
                        @elseif($order->status === 'pending' && !$order->payment_proof)
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#modalBukti{{ $order->id }}">
                                <i class="bi bi-upload"></i> Upload Bukti
                            </button>
                        @else
                            <span class="text-muted small">Menunggu konfirmasi</span>
                        @endif
                    </td>
                </tr>

                {{-- Modal Upload Bukti --}}
                @if($order->status === 'pending' && !$order->payment_proof)
                <div class="modal fade" id="modalBukti{{ $order->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('pembeli.order.bukti', $order) }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <p class="text-muted small mb-3">
                                        Ebook: <strong>{{ $order->ebook->title }}</strong><br>
                                        Total: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                                    </p>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Foto Bukti Transfer</label>
                                        <input type="file" name="payment_proof" accept="image/*"
                                               class="form-control" required>
                                        <div class="form-text">JPG/PNG · Maks 2MB</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        Belum ada pembelian. <a href="{{ route('home') }}">Cari ebook →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Rekomendasi --}}
@if($rekomendasiEbook->isNotEmpty())
<h5 class="fw-bold mb-3">Rekomendasi Untukmu</h5>
<div class="row g-3">
    @foreach($rekomendasiEbook as $ebook)
    <div class="col-md-3">
        <a href="{{ route('ebook.show', $ebook->slug) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100">
                @if($ebook->cover)
                    <img src="{{ Storage::url($ebook->cover) }}"
                         class="card-img-top" style="height:150px;object-fit:cover">
                @else
                    <div style="height:150px;background:linear-gradient(135deg,#6366f1,#4f46e5);
                                display:flex;align-items:center;justify-content:center;
                                color:#fff;font-weight:700;font-size:13px;text-align:center;padding:12px">
                        {{ $ebook->title }}
                    </div>
                @endif
                <div class="card-body p-3">
                    <div style="font-size:10px;color:#e94560;font-weight:700;text-transform:uppercase">
                        {{ $ebook->category->name }}
                    </div>
                    <div class="fw-semibold small mt-1">{{ Str::limit($ebook->title, 40) }}</div>
                    <div class="fw-bold text-danger mt-1 small">
                        Rp {{ number_format($ebook->promo ? $ebook->final_price : $ebook->price, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
@endif
@endsection