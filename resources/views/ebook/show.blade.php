<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ebook->title }} — EbookStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f7f4; }
        .navbar-brand { font-weight: 700; }
        .navbar-brand span { color: #e94560; }
        .cover-placeholder { height: 320px; background: linear-gradient(135deg,#6366f1,#4f46e5); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:18px; text-align:center; padding:24px; border-radius:12px; }
        .star-rating { display: flex; flex-direction: row-reverse; gap: 4px; }
        .star-rating input { display: none; }
        .star-rating label { font-size: 28px; color: #ddd; cursor: pointer; }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label { color: #f5a623; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background:#1a1a2e">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">📚 Ebook<span>Store</span></a>
        <div class="d-flex gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">← Katalog</a>
            @auth
                @if(auth()->user()->isPembeli())
                    <a href="{{ route('pembeli.dashboard') }}" class="btn btn-sm" style="background:#e94560;color:#fff">Dashboard</a>
                @endif
            @endauth
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row g-5">
        {{-- Cover --}}
        <div class="col-md-3">
            @if($ebook->cover)
                <img src="{{ Storage::url($ebook->cover) }}"
                     class="img-fluid rounded shadow" style="width:100%;object-fit:cover">
            @else
                <div class="cover-placeholder">{{ $ebook->title }}</div>
            @endif
        </div>

        {{-- Info --}}
        <div class="col-md-9">
            <div style="font-size:11px;font-weight:700;color:#e94560;text-transform:uppercase;letter-spacing:.1em">
                {{ $ebook->category->name }}
            </div>
            <h1 class="fw-bold mt-2 mb-1" style="font-size:32px">{{ $ebook->title }}</h1>
            <p class="text-muted mb-3">oleh <strong>{{ $ebook->seller->name }}</strong></p>

            {{-- Rating --}}
            @if($ebook->reviews->count() > 0)
            <div class="mb-3">
                @php $avgRating = $ebook->reviews->avg('rating') @endphp
                @for($i = 1; $i <= 5; $i++)
                    <span style="color:{{ $i <= round($avgRating) ? '#f5a623' : '#ddd' }};font-size:18px">★</span>
                @endfor
                <span class="text-muted small ms-1">{{ number_format($avgRating, 1) }} ({{ $ebook->reviews->count() }} ulasan)</span>
            </div>
            @endif

            {{-- Harga --}}
            <div class="card border-0 shadow-sm p-3 mb-3 d-inline-block">
                @if($ebook->promo)
                    <div class="d-flex align-items-center gap-3">
                        <span class="fw-bold text-danger" style="font-size:28px">
                            Rp {{ number_format($ebook->final_price, 0, ',', '.') }}
                        </span>
                        <span class="text-muted text-decoration-line-through">
                            Rp {{ number_format($ebook->price, 0, ',', '.') }}
                        </span>
                        <span class="badge bg-danger">-{{ $ebook->promo->discount_percent }}%</span>
                    </div>
                @else
                    <span class="fw-bold" style="font-size:28px">
                        Rp {{ number_format($ebook->price, 0, ',', '.') }}
                    </span>
                @endif
            </div>

            {{-- Aksi --}}
            @auth
                @if(auth()->user()->isPembeli())
                    @if($sudahBeli)
                        {{-- Sudah beli → tombol download --}}
                        @php
                            $order = \App\Models\Order::where('buyer_id', auth()->id())
                                ->where('ebook_id', $ebook->id)
                                ->where('status', 'lunas')->first();
                        @endphp
                        <div class="mb-3">
                            <a href="{{ route('pembeli.download', $order) }}"
                               class="btn btn-success btn-lg me-2">
                                <i class="bi bi-download"></i> Unduh Ebook
                            </a>
                            <span class="text-success small"><i class="bi bi-check-circle"></i> Sudah dibeli</span>
                        </div>
                    @else
                        <form action="{{ route('pembeli.order.store', $ebook) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg"
                                    onclick="return confirm('Beli ebook ini seharga Rp {{ number_format($ebook->promo ? $ebook->final_price : $ebook->price, 0, ',', '.') }}?')">
                                <i class="bi bi-cart-plus"></i> Beli Sekarang
                            </button>
                        </form>
                    @endif
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-danger btn-lg mb-3">
                    <i class="bi bi-cart-plus"></i> Beli Sekarang
                </a>
            @endauth

            <div class="text-muted small">
                <i class="bi bi-shield-check text-success"></i> Pembayaran aman &nbsp;·&nbsp;
                <i class="bi bi-file-pdf text-danger"></i> Format PDF &nbsp;·&nbsp;
                <i class="bi bi-infinity text-primary"></i> Unduh selamanya
            </div>

            {{-- Deskripsi --}}
            <hr class="my-4">
            <h5 class="fw-bold mb-3">Tentang Ebook Ini</h5>
            <p style="line-height:1.8;color:#444">{{ $ebook->description }}</p>
        </div>
    </div>

    {{-- Ulasan --}}
    <div class="row mt-5">
        <div class="col-md-8">
            <h5 class="fw-bold mb-4">Ulasan Pembeli ({{ $ebook->reviews->count() }})</h5>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Form Ulasan --}}
            @auth
                @if(auth()->user()->isPembeli() && $sudahBeli)
                    @php
                        $sudahReview = \App\Models\Review::where('buyer_id', auth()->id())
                            ->where('ebook_id', $ebook->id)->exists();
                    @endphp
                    @if(!$sudahReview)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Tulis Ulasan</h6>
                            <form action="{{ route('pembeli.review.store', $ebook) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Rating</label>
                                    <div class="star-rating">
                                        @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                                        <label for="star{{ $i }}">★</label>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Komentar (opsional)</label>
                                    <textarea name="comment" rows="3" class="form-control"
                                              placeholder="Bagaimana pengalamanmu dengan ebook ini?"></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger btn-sm px-4">Kirim Ulasan</button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endif
            @endauth

            {{-- Daftar Ulasan --}}
            @forelse($ebook->reviews as $review)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="fw-semibold">{{ $review->buyer->name }}</span>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="color:{{ $i <= $review->rating ? '#f5a623' : '#ddd' }}">★</span>
                                @endfor
                            </div>
                        </div>
                        <span class="text-muted small">{{ $review->created_at->format('d M Y') }}</span>
                    </div>
                    @if($review->comment)
                        <p class="mb-0 mt-2 text-muted">{{ $review->comment }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-4">
                <div class="fs-2">⭐</div>
                Belum ada ulasan untuk ebook ini.
            </div>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>