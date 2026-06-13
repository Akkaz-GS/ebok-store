<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} — EbookStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f7f4; }
        .navbar-brand { font-weight: 700; }
        .navbar-brand span { color: #e94560; }
        .ebook-card { transition: transform .2s, box-shadow .2s; }
        .ebook-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.1) !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background:#1a1a2e">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">📚 Ebook<span>Store</span></a>
        <div class="d-flex gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">← Beranda</a>
            @auth
                @if(auth()->user()->isPembeli())
                    <a href="{{ route('pembeli.dashboard') }}" class="btn btn-sm" style="background:#e94560;color:#fff">Dashboard</a>
                @elseif(auth()->user()->isPenjual())
                    <a href="{{ route('penjual.dashboard') }}" class="btn btn-sm" style="background:#e94560;color:#fff">Dashboard</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Masuk</a>
            @endauth
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="mb-4">
        <h2 class="fw-bold">Kategori: {{ $category->name }}</h2>
        <p class="text-muted">{{ $ebooks->total() }} ebook ditemukan</p>
    </div>

    @if($ebooks->isEmpty())
        <div class="text-center py-5 text-muted">
            <div class="fs-1">📚</div>
            <p>Belum ada ebook di kategori ini.</p>
            <a href="{{ route('home') }}" class="btn btn-danger">← Kembali ke Beranda</a>
        </div>
    @else
        <div class="row g-3">
            @foreach($ebooks as $ebook)
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('ebook.show', $ebook->slug) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm ebook-card h-100">
                        @if($ebook->cover)
                            <img src="{{ Storage::url($ebook->cover) }}"
                                 class="card-img-top" style="height:180px;object-fit:cover">
                        @else
                            <div style="height:180px;background:linear-gradient(135deg,#6366f1,#4f46e5);
                                        display:flex;align-items:center;justify-content:center;
                                        color:#fff;font-weight:700;font-size:14px;text-align:center;padding:16px">
                                {{ $ebook->title }}
                            </div>
                        @endif
                        <div class="card-body">
                            <div style="font-size:10px;color:#e94560;font-weight:700;text-transform:uppercase">
                                {{ $ebook->category->name }}
                            </div>
                            <div class="fw-semibold small mt-1">{{ Str::limit($ebook->title, 45) }}</div>
                            <div class="text-muted small">{{ $ebook->seller->name }}</div>
                            <div class="fw-bold text-danger mt-2">
                                Rp {{ number_format($ebook->promo ? $ebook->final_price : $ebook->price, 0, ',', '.') }}
                                @if($ebook->promo)
                                    <span class="badge bg-danger ms-1" style="font-size:10px">-{{ $ebook->promo->discount_percent }}%</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $ebooks->links() }}</div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>