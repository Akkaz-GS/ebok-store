<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EbookStore - Platform Ebook Terpercaya')</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #1c2230;
            --bg-cream: #f8f6f1;
            --bg-cream-2: #f1eee8;
            --accent: #a3253f;
            --accent-dark: #882035;
            --text-dark: #20242f;
            --text-muted: #8b8d98;
            --input-bg: #eef1f6;
            --border-light: #e3e0d8;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background: var(--bg-cream);
        }

        /* ===== Navbar ===== */
        .site-navbar {
            background: var(--bg-cream);
            border-bottom: 1px solid var(--border-light);
            padding: 16px 0;
        }

        .brand-logo {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--accent) !important;
        }

        .site-navbar .nav-link {
            color: var(--text-dark);
            font-weight: 500;
            margin: 0 4px;
            position: relative;
        }

        .site-navbar .nav-link.active { color: var(--accent); }

        .site-navbar .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0; right: 0; bottom: -6px;
            height: 2px;
            background: var(--accent);
            border-radius: 2px;
        }

        .btn-outline-nav {
            border: 1px solid var(--border-light);
            color: var(--text-dark);
            border-radius: 8px;
            padding: 8px 18px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .btn-outline-nav:hover { background: #fff; color: var(--text-dark); }

        .btn-signup-nav {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .btn-signup-nav:hover { background: var(--accent-dark); color: #fff; }

        /* ===== Hero ===== */
        .hero-section {
            background: linear-gradient(135deg, #f3ece6 0%, #f8f6f1 60%);
            padding: 72px 0;
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 3rem;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .text-accent { color: var(--accent); }

        .hero-desc {
            color: var(--text-muted);
            font-size: 1.02rem;
            line-height: 1.7;
            max-width: 460px;
            margin-bottom: 28px;
        }

        .hero-search { max-width: 560px; }

        .search-input-wrap { position: relative; flex: 1; }
        .search-input-wrap i {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        .search-input-wrap .form-control {
            height: 52px;
            padding-left: 44px;
            border-radius: 10px;
            border: 1px solid var(--border-light);
            background: #fff;
        }
        .search-input-wrap .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(163, 37, 63, 0.12);
        }

        .btn-search {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0 28px;
            font-weight: 600;
            font-size: 0.95rem;
            height: 52px;
        }
        .btn-search:hover { background: var(--accent-dark); color: #fff; }

        .hero-meta { color: var(--text-muted); font-size: 0.92rem; }

        .avatar-group { display: flex; }
        .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 2px solid var(--bg-cream);
            background: var(--accent);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem;
            margin-left: -10px;
        }
        .avatar:first-child { margin-left: 0; }
        .avatar:nth-child(2) { background: #3a4156; }
        .avatar:nth-child(3) { background: #8b8d98; }

        /* Featured book card */
        .hero-visual { position: relative; padding: 20px; }

        .featured-card {
            background: linear-gradient(135deg, #e9e4dc 0%, #d8d2c8 100%);
            border-radius: 20px;
            padding: 24px;
            transform: rotate(2deg);
            box-shadow: 0 30px 60px -20px rgba(28, 34, 48, 0.35);
        }

        .featured-cover {
            position: relative;
            height: 320px;
            border-radius: 14px;
            overflow: hidden;
            background: linear-gradient(160deg, var(--accent) 0%, var(--accent) 55%, var(--bg-dark) 55%, var(--bg-dark) 100%);
            display: flex;
            align-items: flex-end;
            padding: 24px;
        }

        .cover-shape-1 {
            position: absolute;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            top: -60px; right: -60px;
        }

        .cover-shape-2 {
            position: absolute;
            width: 160px; height: 160px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.15);
            bottom: 40px; left: -50px;
        }

        .cover-text {
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.4rem;
            line-height: 1.3;
            z-index: 1;
        }

        .featured-info { margin-top: 18px; padding: 0 6px; }
        .featured-label { font-size: 0.72rem; letter-spacing: 0.1em; color: var(--text-muted); font-weight: 600; }
        .featured-info h3 { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 1.1rem; margin: 6px 0 2px; }
        .featured-info p { font-size: 0.9rem; color: var(--text-muted); margin: 0; }

        .featured-badge {
            position: absolute;
            left: -16px;
            bottom: 70px;
            background: #fff;
            border-radius: 12px;
            padding: 12px 16px;
            box-shadow: 0 12px 30px -10px rgba(28, 34, 48, 0.25);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .featured-badge i {
            width: 36px; height: 36px;
            border-radius: 8px;
            background: rgba(163, 37, 63, 0.12);
            color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .featured-badge strong { display: block; font-size: 0.72rem; letter-spacing: 0.06em; }
        .featured-badge span { font-size: 0.8rem; color: var(--text-muted); }

        /* ===== Generic section headers ===== */
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 6px;
        }
        .section-subtitle { color: var(--text-muted); font-size: 0.95rem; }
        .link-arrow {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
        }
        .link-arrow:hover { text-decoration: underline; }

        /* ===== Ebook cards ===== */
        .section-ebooks { padding: 64px 0; }

        .ebook-cover {
            border-radius: 12px;
            overflow: hidden;
            background: var(--input-bg);
            aspect-ratio: 3 / 4;
            margin-bottom: 14px;
        }
        .ebook-cover img { width: 100%; height: 100%; object-fit: cover; }
        .ebook-cover-placeholder {
            width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--bg-dark) 0%, var(--accent) 100%);
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            text-align: center;
            padding: 16px;
            line-height: 1.3;
        }
        .promo-badge {
            background: var(--accent);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 4px;
            vertical-align: middle;
        }
        .ebook-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.98rem;
            margin-bottom: 2px;
            display: block;
            color: var(--text-dark);
            text-decoration: none;
        }
        .ebook-title:hover { color: var(--accent); }
        .ebook-author { color: var(--text-muted); font-size: 0.85rem; margin-bottom: 6px; }
        .ebook-price { color: var(--accent); font-weight: 700; font-size: 0.95rem; margin: 0; }

        /* ===== Categories ===== */
        .section-categories { background: var(--bg-cream-2); padding: 64px 0; }

        .category-card {
            display: block;
            background: #fff;
            border: 1px solid var(--border-light);
            border-radius: 14px;
            padding: 28px;
            height: 100%;
            text-decoration: none;
            color: var(--text-dark);
            transition: box-shadow .2s ease, transform .2s ease;
        }
        .category-card:hover {
            box-shadow: 0 12px 30px -15px rgba(28, 34, 48, 0.2);
            transform: translateY(-2px);
            color: var(--text-dark);
        }
        .category-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            background: rgba(163, 37, 63, 0.1);
            color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 18px;
        }
        .category-card h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 4px;
        }
        .category-card p { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 14px; }
        .category-link { color: var(--accent); font-weight: 600; font-size: 0.9rem; }

        .cta-card-dark {
            background: var(--bg-dark);
            color: #fff;
            border-radius: 14px;
            padding: 28px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .cta-card-dark h3 { font-family: 'Poppins', sans-serif; font-weight: 600; margin-bottom: 8px; }
        .cta-card-dark p { color: rgba(255, 255, 255, 0.65); font-size: 0.92rem; margin-bottom: 20px; }
        .btn-light-cta {
            background: #fff;
            color: var(--text-dark);
            border-radius: 8px;
            padding: 10px 22px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
            width: fit-content;
        }
        .btn-light-cta:hover { background: var(--bg-cream-2); color: var(--text-dark); }

        /* ===== Newsletter ===== */
        .section-newsletter { padding: 64px 0; }
        .newsletter-card {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
            border-radius: 24px;
            padding: 56px 24px;
            text-align: center;
            color: #fff;
        }
        .newsletter-card h2 { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem; margin-bottom: 12px; }
        .newsletter-card p { color: rgba(255, 255, 255, 0.8); max-width: 520px; margin: 0 auto 28px; }
        .newsletter-form { max-width: 480px; margin: 0 auto; }
        .newsletter-form .form-control { height: 50px; border-radius: 10px; border: none; }
        .btn-newsletter {
            background: var(--bg-dark);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0 28px;
            font-weight: 600;
            white-space: nowrap;
        }
        .btn-newsletter:hover { background: #0e1118; color: #fff; }

        /* ===== Footer ===== */
        .site-footer { background: var(--bg-cream-2); padding: 56px 0 24px; }
        .footer-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--accent);
            margin-bottom: 12px;
        }
        .site-footer p { color: var(--text-muted); font-size: 0.92rem; }
        .site-footer h4 {
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 14px;
        }
        .site-footer ul { list-style: none; padding: 0; margin: 0; }
        .site-footer ul li { margin-bottom: 10px; }
        .site-footer ul li a { color: var(--text-muted); text-decoration: none; font-size: 0.92rem; }
        .site-footer ul li a:hover { color: var(--accent); }
        .social-icons { display: flex; gap: 10px; margin-top: 18px; }
        .social-icons a {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid var(--border-light);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-dark);
            text-decoration: none;
        }
        .social-icons a:hover { color: var(--accent); }
        .footer-bottom {
            border-top: 1px solid var(--border-light);
            margin-top: 36px;
            padding-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            color: var(--text-muted);
            font-size: 0.85rem;
        }
        .payment-icons { display: flex; gap: 8px; }
        .payment-icons span {
            background: #fff;
            border: 1px solid var(--border-light);
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        @media (max-width: 991px) {
            .hero-title { font-size: 2.2rem; }
            .featured-badge { left: 8px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- ===== Navbar ===== --}}
    <nav class="navbar navbar-expand-lg site-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand brand-logo" href="{{ route('home') }}">EbookStore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto gap-lg-4 text-center mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    {{-- Sesuaikan href di bawah jika route Catalog / Pricing / About sudah dibuat --}}
                    <li class="nav-item"><a class="nav-link" href="#">Catalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                </ul>
                <div class="d-flex gap-2 justify-content-center mt-3 mt-lg-0">
                    @auth
                        @if (auth()->user()->isPembeli())
                            <a href="{{ route('pembeli.dashboard') }}" class="btn btn-outline-nav">Dashboard</a>
                        @elseif (auth()->user()->isPenjual())
                            <a href="{{ route('penjual.dashboard') }}" class="btn btn-outline-nav">Dashboard</a>
                        @elseif (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-nav">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-signup-nav">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-nav">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-signup-nav">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ===== Page content ===== --}}
    @yield('content')

    {{-- ===== Footer ===== --}}
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-brand">EbookStore</div>
                    <p>Platform ebook terpercaya untuk meningkatkan pengetahuan dan keterampilan Anda kapan saja, di mana saja.</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-globe"></i></a>
                        <a href="#"><i class="bi bi-share"></i></a>
                        <a href="#"><i class="bi bi-envelope"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h4>NAVIGASI</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="#">Catalog</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">About Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-6">
                    <h4>LAYANAN</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Redeem Voucher</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-6">
                    <h4>LEGAL</h4>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} EbookStore. All rights reserved.</span>
                <div class="payment-icons">
                    <span>BCA</span>
                    <span>VISA</span>
                    <span>GoPay</span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>