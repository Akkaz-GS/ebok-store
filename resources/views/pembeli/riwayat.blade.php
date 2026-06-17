@extends('layouts.pembeli')

@section('title', 'Riwayat Pembelian - EbookStore')

@section('content')

{{--
    CATATAN STRUKTUR DATA (sesuaikan dengan controller & model Anda):
    - $orders         : paginator Order (with('ebook.seller'), where user_id = auth()->id())
                        -> $order->id, $order->ebook->title, $order->ebook->cover,
                           $order->ebook->seller->name, $order->total_price,
                           $order->status, $order->created_at
    - $totalSpent     : total nominal order dengan status dibayar/selesai (int)
    - $pendingCount   : jumlah order menunggu_verifikasi (int)
    - $completedCount : jumlah order dibayar/selesai (int)

    Status enum yang diasumsikan: 'menunggu_verifikasi', 'dibayar' / 'selesai', 'ditolak'.
    Jika nama kolom/nilai status di tabel orders Anda berbeda, sesuaikan pada
    blok PHP variabel "badge" di bawah dan kondisi if/elseif pada kolom Aksi.
--}}

<h2 class="page-title">Riwayat Pembelian</h2>
<p class="page-subtitle">Tinjau seluruh transaksi ebook yang pernah kamu lakukan.</p>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total Transaksi</div>
        <div class="stat-value">{{ $orders->total() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Pembelian</div>
        <div class="stat-value">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Menunggu Verifikasi</div>
        <div class="stat-value">{{ $pendingCount }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Selesai</div>
        <div class="stat-value">{{ $completedCount }}</div>
    </div>
</div>

<div class="section-block">
    @if ($orders->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-receipt fs-1 text-muted"></i>
            <p class="text-muted mt-2 mb-3">Kamu belum memiliki transaksi.</p>
            <a href="{{ route('home') }}" class="btn-cta-outline">Jelajahi Ebook</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Ebook</th>
                        <th>Tanggal</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="order-ebook">
                                    @if ($order->ebook->cover)
                                        <img src="{{ Storage::url($order->ebook->cover) }}" class="order-thumb" alt="">
                                    @else
                                        <div class="order-thumb"></div>
                                    @endif
                                    <div>
                                        <div class="order-ebook-title">{{ Str::limit($order->ebook->title, 35) }}</div>
                                        <div class="order-ebook-author">{{ $order->ebook->seller->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badge = match ($order->status) {
                                        'menunggu_verifikasi' => ['status-pending', 'Menunggu Verifikasi'],
                                        'dibayar', 'selesai' => ['status-success', 'Selesai'],
                                        'ditolak' => ['status-failed', 'Ditolak'],
                                        default => ['status-pending', $order->status],
                                    };
                                @endphp
                                <span class="status-badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                            </td>
                            <td>
                                @if (in_array($order->status, ['dibayar', 'selesai']))
                                    <a href="{{ route('pembeli.download', $order->id) }}" class="btn-table-action" title="Unduh">
                                        <i class="bi bi-download"></i>
                                    </a>
                                @elseif ($order->status === 'menunggu_verifikasi')
                                    <button type="button" class="btn-table-action" title="Upload Bukti"
                                            data-bs-toggle="modal" data-bs-target="#buktiModal{{ $order->id }}">
                                        <i class="bi bi-upload"></i>
                                    </button>

                                    {{-- Modal upload bukti pembayaran --}}
                                    <div class="modal fade" id="buktiModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('pembeli.order.bukti', $order->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-muted small mb-3">
                                                            Ebook: <strong>{{ $order->ebook->title }}</strong><br>
                                                            Total: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                                                        </p>
                                                        <label class="form-label small fw-semibold">File Bukti Transfer</label>
                                                        <input type="file" name="bukti" class="form-control" accept="image/*,application/pdf" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn-cta">Kirim</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection