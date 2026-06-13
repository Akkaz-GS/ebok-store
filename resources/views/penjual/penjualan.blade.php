@extends('layouts.penjual')
@section('title', 'Kelola Penjualan')

@section('content')
<h4 class="fw-bold mb-1">Kelola Penjualan</h4>
<p class="text-muted mb-4">Konfirmasi pembayaran dari pembeli</p>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Pembeli</th>
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
                    <td>{{ $order->buyer->name }}</td>
                    <td>{{ $order->ebook->title }}</td>
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
                        @if($order->status === 'pending')
                            <form action="{{ route('penjual.order.status', $order) }}"
                                  method="POST" class="d-flex gap-1">
                                @csrf @method('PATCH')
                                <button name="status" value="lunas"
                                        class="btn btn-sm btn-success">
                                    <i class="bi bi-check-lg"></i> Konfirmasi
                                </button>
                                <button name="status" value="ditolak"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Tolak order ini?')">
                                    <i class="bi bi-x-lg"></i> Tolak
                                </button>
                            </form>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">Belum ada order masuk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $orders->links() }}</div>
@endsection