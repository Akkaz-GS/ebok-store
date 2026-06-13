@extends('layouts.pembeli')
@section('title', 'Riwayat Pembelian')

@section('content')
<h4 class="fw-bold mb-1">Riwayat Pembelian</h4>
<p class="text-muted mb-4">Semua transaksi pembelian ebook kamu</p>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Ebook</th>
                    <th>Harga</th>
                    <th>Bukti Bayar</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $order->ebook->title }}</div>
                        <div class="text-muted small">{{ $order->ebook->category->name }}</div>
                    </td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>
                        @if($order->payment_proof)
                            <a href="{{ Storage::url($order->payment_proof) }}" target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-image"></i> Lihat
                            </a>
                        @else
                            <span class="text-muted small">Belum upload</span>
                        @endif
                    </td>
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
                        @elseif($order->status === 'pending' && $order->payment_proof)
                            <span class="text-muted small"><i class="bi bi-clock"></i> Menunggu</span>
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
                                        <input type="file" name="payment_proof"
                                               accept="image/*" class="form-control" required>
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
                    <td colspan="6" class="text-center py-5 text-muted">
                        <div class="fs-1">🛒</div>
                        Belum ada pembelian. <a href="{{ route('home') }}">Cari ebook →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $orders->links() }}</div>
@endsection