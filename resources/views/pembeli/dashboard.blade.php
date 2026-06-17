@extends('layouts.pembeli')

@section('title', 'Dashboard - EbookStore')

@section('content')

{{--
    CATATAN STRUKTUR DATA (sesuaikan dengan controller & model Anda):
    - $totalEbooks       : jumlah ebook yang sudah dibeli & terverifikasi (int)
    - $totalSpent        : total nominal pembelian terverifikasi (int/decimal)
    - $pendingOrders     : jumlah order dengan status menunggu verifikasi (int)
    - $totalReviews      : jumlah ulasan yang sudah diberikan user (int)
    - $recentOrders      : collection Order (with('ebook.seller')) -> $order->ebook->title,
                            $order->ebook->cover, $order->ebook->seller->name,
                            $order->total_price, $order->status, $order->created_at, $order->id
    - $recommendedEbooks : collection Ebook (with(['seller','promo'])) -> $ebook->title, $ebook->slug,
                            $ebook->cover, $ebook->price, $ebook->seller->name,
                            $ebook->promo->discount_percent, $ebook->final_price
--}}

{{-- ===== Welcome Banner ===== --}}
<div class="welcome-banner">
    <div>
        <div class="eyebrow">SELAMAT DATANG KEMBALI</div>
        <h2>Halo, {{ Auth::user()->name }}! Jelajahi koleksi ebook terbaru kami.</h2>
        <p>Pantau status pesanan, unduh ebook yang sudah terverifikasi, dan temukan rekomendasi bacaan baru di sini.</p>
        <a href="{{ route('home') }}" class="btn-cta">Jelajahi Ebook <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="welcome-visual"><i class="bi bi-book-half"></i></div>
</div>

{{-- ===== Stat Cards ===== --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(163,37,63,0.1); color: var(--accent);">
            <i class="bi bi-collection"></i>
        </div>
        <div class="stat-label">Total Ebook Dibeli</div>
        <div class="stat-value">{{ $totalEbooks }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(28,34,48,0.06); color: var(--bg-dark);">
            <i class="bi bi-wallet2"></i>
        </div>
        <div class="stat-label">Total Pembelian</div>
        <div class="stat-value">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #fdf3d9; color: #a9762b;">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div class="stat-label">Menunggu Verifikasi</div>
        <div class="stat-value">{{ $pendingOrders }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #dff3e6; color: #1f9d55;">
            <i class="bi bi-star"></i>
        </div>
        <div class="stat-label">Ulasan Diberikan</div>
        <div class="stat-value">{{ $totalReviews }}</div>
    </div>
</div>

{{-- ===== Pesanan Terbaru ===== --}}
<div class="section-block">
    <div class="section-header">
        <div>
            <h3>Pesanan Terbaru</h3>
            <p>Status pesanan ebook yang baru kamu beli.</p>
        </div>
        <a href="{{ route('pembeli.order.index') }}" class="link-arrow">Lihat Semua <i class="bi bi-arrow-right"></i></a>
    </div>

    @if ($recentOrders->isEmpty())
        <p class="text-muted mb-0">Belum ada pesanan. Yuk mulai jelajahi ebook!</p>
    @else
        <div class="table-responsive">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Ebook</th>
                        <th>Tanggal</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentOrders as $order)
                        <tr>
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
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- ===== Rekomendasi Untukmu ===== --}}
<div class="section-block">
    <div class="section-header">
        <div>
            <h3>Rekomendasi Untukmu</h3>
            <p>Ebook terbaru yang mungkin kamu suka.</p>
        </div>
        <a href="{{ route('home') }}" class="link-arrow">Lihat Semua <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="ebook-grid">
        @forelse ($recommendedEbooks as $ebook)
            <div>
                <a href="{{ route('ebook.show', $ebook->slug) }}" class="text-decoration-none">
                    <div class="mini-ebook-cover">
                        @if ($ebook->cover)
                            <img src="{{ Storage::url($ebook->cover) }}" alt="{{ $ebook->title }}">
                        @else
                            <div class="placeholder">{{ $ebook->title }}</div>
                        @endif
                    </div>
                    <span class="mini-ebook-title">{{ Str::limit($ebook->title, 30) }}</span>
                </a>
                <div class="mini-ebook-author">{{ $ebook->seller->name }}</div>
                <div class="mini-ebook-price">
                    Rp {{ number_format($ebook->promo ? $ebook->final_price : $ebook->price, 0, ',', '.') }}
                    @if ($ebook->promo)
                        <span class="promo-badge">-{{ $ebook->promo->discount_percent }}%</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada ebook tersedia.</p>
        @endforelse
    </div>
</div>

@endsection