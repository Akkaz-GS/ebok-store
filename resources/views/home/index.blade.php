<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EbookStore — Toko Ebook Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f7f4; }
        .navbar-brand { font-weight: 700; font-size: 20px; }
        .navbar-brand span { color: #e94560; }
        .hero { background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%); color: #fff; padding: 80px 0; }
        .hero h1 { font-size: 48px; font-weight: 700; line-height: 1.2; }
        .hero h1 em { color: #e94560; font-style: normal; }
        .ebook-card { transition: transform .2s, box-shadow .2s; }
        .ebook-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.1) !important; }
        .cover-box { height: 180px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #fff; font-size: 14px; text-align: center; padding: 16px; }
        .badge-promo { background: #e94560; color: #fff; font-size: 10px; padding: 2px 8px; border-radius: 20px; }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#1a1a2e">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">📚 Ebook<span>Store</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto gap-2">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                @foreach($categories->take(4) as $cat)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home.kategori', $cat->slug) }}">{{ $cat->name }}</a>
                </li>
                @endforeach
            </ul>
            <div class="d-flex gap-2">
                @auth
                    @if(auth()->user()->isPembeli())
                        <a href="{{ route('pembeli.dashboard') }}" class="btn btn-outline-light btn-sm">Dashboard</a>
                    @elseif(auth()->user()->isPenjual())
                        <a href="{{ route('penjual.dashboard') }}" class="btn btn-outline-light btn-sm">Dashboard</a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-sm" style="background:#e94560;color:#fff">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Hero --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <p style="color:#f5a623;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase">
                    ✦ Toko Ebook Digital #1
                </p>
                <h1>Beli, Baca &<br><em>Berkembang</em><br>Kapan Saja</h1>
                <p class="mt-3 mb-4" style="color:rgba(255,255,255,.65);font-size:16px">
                    Ribuan ebook berkualitas dari penulis terpercaya.<br>Beli sekali, unduh selamanya.
                </p>
                <a href="#katalog" class="btn btn-danger btn-lg me-2">Jelajahi Katalog →</a>
                @guest
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Jual Ebook Anda</a>
                @endguest
            </div>
        </div>
    </div>
</section>

{{-- Search --}}
<div style="background:#fff;border-bottom:1px solid #e5e7eb;padding:20px 0">
    <div class="container">
        <form action="{{ route('home') }}" method="GET" class="d-flex gap-2" style="max-width:700px">
            <input type="text" name="search" class="form-control"
                   placeholder="Cari judul, penulis, atau topik..."
                   value="{{ request('search') }}">
            <select name="category" class="form-select" style="max-width:180px">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-danger px-4">🔍 Cari</button>
        </form>
    </div>
</div>

{{-- Katalog --}}
<section class="py-5" id="katalog">
    <div class="container">

        {{-- Header hasil pencarian --}}
        @if(request('search') || request('category'))
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Hasil Pencarian</h2>
                <p class="text-muted small mb-0">
                    @if(request('search'))
                        Kata kunci: <strong>"{{ request('search') }}"</strong>
                    @endif
                    @if(request('category'))
                        · Kategori: <strong>{{ $categories->firstWhere('slug', request('category'))?->name }}</strong>
                    @endif
                    · <strong>{{ $ebooks->total() }}</strong> ebook ditemukan
                </p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                ✕ Reset Pencarian
            </a>
        </div>
        @else
        <h2 class="fw-bold mb-1">Ebook Terbaru</h2>
        <p class="text-muted mb-4">Temukan ebook yang tepat untukmu</p>
        @endif

        @if($ebooks->isEmpty())
            <div class="text-center py-5 text-muted">
                <div class="fs-1">🔍</div>
                <p class="mt-2">Tidak ada ebook yang cocok dengan pencarian kamu.</p>
                <a href="{{ route('home') }}" class="btn btn-danger btn-sm">Lihat Semua Ebook</a>
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
                            <div class="cover-box"
                                 style="background:linear-gradient(135deg,#6366f1,#4f46e5)">
                                {{ $ebook->title }}
                            </div>
                        @endif
                        <div class="card-body">
                            <div style="font-size:10px;font-weight:700;color:#e94560;text-transform:uppercase;letter-spacing:.08em">
                                {{ $ebook->category->name }}
                            </div>
                            <div class="fw-semibold mt-1" style="font-size:14px;line-height:1.4">
                                {{ Str::limit($ebook->title, 45) }}
                            </div>
                            <div class="text-muted small mt-1">{{ $ebook->seller->name }}</div>
                            <div class="mt-2 d-flex align-items-center gap-2 flex-wrap">
                                @if($ebook->promo)
                                    <span class="fw-bold text-danger">
                                        Rp {{ number_format($ebook->final_price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-muted small text-decoration-line-through">
                                        Rp {{ number_format($ebook->price, 0, ',', '.') }}
                                    </span>
                                    <span class="badge-promo">-{{ $ebook->promo->discount_percent }}%</span>
                                @else
                                    <span class="fw-bold">
                                        Rp {{ number_format($ebook->price, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">{{ $ebooks->links() }}</div>
        @endif

    </div>
</section>

{{-- Stats --}}
<div style="background:#1a1a2e;color:#fff;padding:40px 0">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div style="font-size:36px;font-weight:700;color:#e94560">{{ $ebooks->count() }}+</div>
                <div style="font-size:13px;color:rgba(255,255,255,.6)">Ebook Tersedia</div>
            </div>
            <div class="col-md-4">
                <div style="font-size:36px;font-weight:700;color:#f5a623">{{ $categories->count() }}</div>
                <div style="font-size:13px;color:rgba(255,255,255,.6)">Kategori</div>
            </div>
            <div class="col-md-4">
                <div style="font-size:36px;font-weight:700;color:#10b981">100%</div>
                <div style="font-size:13px;color:rgba(255,255,255,.6)">Aman & Terverifikasi</div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>