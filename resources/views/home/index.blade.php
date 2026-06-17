@extends('layouts.public')

@section('title', 'EbookStore - Beli, Baca & Berkembang Kapan Saja')

@section('content')

{{--
    CATATAN STRUKTUR DATA:
    - $ebooks  : paginator Ebook (sebaiknya eager-load: with(['category','seller','promo']))
                 dipakai: $ebook->title, $ebook->slug, $ebook->cover, $ebook->price,
                          $ebook->seller->name, $ebook->category->name,
                          $ebook->promo->discount_percent, $ebook->final_price
    - $categories : collection Category (withCount('ebooks')) -> dipakai:
                 $category->name, $category->slug, $category->ebooks_count
--}}

{{-- ===== Hero Section ===== --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <h1 class="hero-title">
                    Beli, Baca &amp; <span class="text-accent">Berkembang</span> Kapan Saja
                </h1>
                <p class="hero-desc">
                    Temukan ribuan koleksi ebook terbaik dari penulis lokal maupun
                    internasional. Tingkatkan pengetahuan Anda dengan akses instan di mana
                    saja.
                </p>

                <form action="{{ route('home') }}" method="GET" class="hero-search d-flex gap-2 mb-4">
                    <div class="search-input-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control" placeholder="Cari judul buku, penulis, atau kategori...">
                    </div>
                    <button type="submit" class="btn btn-search">Cari Sekarang</button>
                </form>

                <div class="hero-meta d-flex align-items-center gap-3">
                    <div class="avatar-group">
                        <div class="avatar"><i class="bi bi-person-fill"></i></div>
                        <div class="avatar"><i class="bi bi-person-fill"></i></div>
                        <div class="avatar"><i class="bi bi-person-fill"></i></div>
                    </div>
                    <span>Bergabung dengan 10.000+ pembaca aktif</span>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-visual">
                    <div class="featured-card">
                        <div class="featured-cover">
                            <div class="cover-shape-1"></div>
                            <div class="cover-shape-2"></div>
                            <div class="cover-text">The Art of<br>Modern Growth</div>
                        </div>
                        <div class="featured-info">
                            <span class="featured-label">FEATURED AUTHOR</span>
                            <h3>The Art of Modern Growth</h3>
                            <p>by Adrian Sulivan</p>
                        </div>
                    </div>
                    <div class="featured-badge">
                        <i class="bi bi-graph-up-arrow"></i>
                        <div>
                            <strong>BESTSELLER</strong>
                            <span>500+ Terjual Hari Ini</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== Ebook Terbaru ===== --}}
<section class="section-ebooks">
    <div class="container">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
            <div>
                <h2 class="section-title">Ebook Terbaru</h2>
                <p class="section-subtitle mb-0">Koleksi terhangat yang baru saja rilis minggu ini.</p>
            </div>
            <a href="{{ route('home') }}" class="link-arrow">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">
            @forelse ($ebooks as $ebook)
                <div class="col">
                    <a href="{{ route('ebook.show', $ebook->slug) }}" class="text-decoration-none">
                        <div class="ebook-cover">
                            @if ($ebook->cover)
                                <img src="{{ Storage::url($ebook->cover) }}" alt="{{ $ebook->title }}">
                            @else
                                <div class="ebook-cover-placeholder">{{ $ebook->title }}</div>
                            @endif
                        </div>
                        <span class="ebook-title">{{ Str::limit($ebook->title, 40) }}</span>
                    </a>
                    <p class="ebook-author">{{ $ebook->seller->name }}</p>
                    <p class="ebook-price">
                        Rp {{ number_format($ebook->promo ? $ebook->final_price : $ebook->price, 0, ',', '.') }}
                        @if ($ebook->promo)
                            <span class="promo-badge">-{{ $ebook->promo->discount_percent }}%</span>
                        @endif
                    </p>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">Belum ada ebook yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Aktifkan pagination jika perlu:
        <div class="mt-5">{{ $ebooks->links() }}</div>
        --}}
    </div>
</section>

{{-- ===== Kategori Populer ===== --}}
<section class="section-categories">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Kategori Populer</h2>
            <p class="section-subtitle">Jelajahi berbagai genre pilihan yang paling banyak diminati oleh pembaca kami.</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($categories as $category)
                @php
                    // Pemetaan ikon sederhana berdasarkan nama kategori (opsional, bisa disesuaikan)
                    $iconMap = [
                        'bisnis' => 'bi-graph-up-arrow',
                        'finansial' => 'bi-graph-up-arrow',
                        'pengembangan' => 'bi-lightbulb',
                        'diri' => 'bi-lightbulb',
                        'teknologi' => 'bi-laptop',
                        'it' => 'bi-laptop',
                        'seni' => 'bi-palette',
                        'desain' => 'bi-palette',
                        'fiksi' => 'bi-mask',
                        'sastra' => 'bi-mask',
                    ];
                    $categoryName = strtolower($category->name);
                    $icon = 'bi-bookmark';
                    foreach ($iconMap as $keyword => $iconClass) {
                        if (str_contains($categoryName, $keyword)) {
                            $icon = $iconClass;
                            break;
                        }
                    }
                @endphp
                <div class="col">
                    <a href="{{ route('home.kategori', $category->slug) }}" class="category-card">
                        <div class="category-icon"><i class="{{ $icon }}"></i></div>
                        <h3>{{ $category->name }}</h3>
                        <p>{{ $category->ebooks_count }}+ Ebook Tersedia</p>
                        <span class="category-link">Jelajahi <i class="bi bi-arrow-right"></i></span>
                    </a>
                </div>
            @endforeach

            {{-- Kartu CTA statis untuk calon penjual --}}
            <div class="col">
                <div class="cta-card-dark">
                    <h3>Ingin Menulis Ebook?</h3>
                    <p>Daftar sebagai penulis dan mulai jual karya Anda.</p>
                    <a href="{{ route('register') }}" class="btn-light-cta">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== Newsletter ===== --}}
<section class="section-newsletter">
    <div class="container">
        <div class="newsletter-card">
            <h2>Mulai Perjalanan Belajar Anda</h2>
            <p>Dapatkan update buku terbaru dan diskon eksklusif langsung di inbox Anda. Gratis selamanya!</p>
            <form class="newsletter-form d-flex gap-2" action="#" method="POST">
                @csrf
                <input type="email" name="email" class="form-control" placeholder="Alamat email Anda" required>
                <button type="submit" class="btn-newsletter">Berlangganan</button>
            </form>
        </div>
    </div>
</section>

@endsection