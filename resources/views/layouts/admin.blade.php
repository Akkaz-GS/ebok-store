<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EbookStore')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --accent: #a3253f;
            --accent-dark: #882035;
            --sidebar-bg: #4a5268;
            --bg-cream: #f8f6f1;
            --bg-dark: #1c2230;
            --text-dark: #20242f;
            --text-muted: #8b8d98;
            --border-light: #e3e0d8;
            --input-bg: #eef1f6;
        }

        * { box-sizing: border-box; }
        html, body { margin: 0; font-family: 'Inter', sans-serif; color: var(--text-dark); background: var(--bg-cream); }

        .dashboard-wrapper { display: flex; min-height: 100vh; }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: #fff;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            padding: 24px 16px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1040;
        }

        .sidebar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 8px 12px 24px;
        }

        .sidebar-nav { display: flex; flex-direction: column; gap: 6px; flex: 1; }

        .sidebar-nav a {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: background .15s ease, color .15s ease;
        }
        .sidebar-nav a:hover { background: rgba(255, 255, 255, 0.08); color: #fff; }
        .sidebar-nav a.active { background: var(--accent); color: #fff; }
        .sidebar-nav a i { font-size: 1.1rem; width: 20px; text-align: center; }

        .sidebar-footer { margin-top: auto; display: flex; flex-direction: column; gap: 14px; }

        .btn-browse {
            background: var(--accent);
            color: #fff;
            border-radius: 10px;
            padding: 12px 16px;
            text-align: center;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.92rem;
        }
        .btn-browse:hover { background: var(--accent-dark); color: #fff; }

        .user-mini {
            display: flex; align-items: center; gap: 10px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .avatar-circle {
            width: 38px; height: 38px; border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; flex-shrink: 0;
        }
        .user-mini strong { display: block; font-size: 0.9rem; font-weight: 600; }
        .user-mini span { font-size: 0.78rem; color: rgba(255, 255, 255, 0.55); }
        .user-mini form { margin-left: auto; }
        .user-mini .logout-btn {
            background: none; border: none; color: rgba(255, 255, 255, 0.55);
            font-size: 1.1rem; cursor: pointer; padding: 4px;
        }
        .user-mini .logout-btn:hover { color: #fff; }

        /* ===== Main area ===== */
        .main-area { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--border-light);
            padding: 18px 32px;
            display: flex; align-items: center; justify-content: space-between; gap: 20px;
        }
        .sidebar-toggle {
            display: none;
            border: 1px solid var(--border-light);
            background: #fff;
            border-radius: 8px;
            width: 40px; height: 40px;
            align-items: center; justify-content: center;
            font-size: 1.1rem; color: var(--text-dark);
        }
        .topbar-search { position: relative; flex: 1; max-width: 480px; }
        .topbar-search i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        .topbar-search input {
            width: 100%; height: 44px; padding-left: 42px;
            border: 1px solid var(--border-light); border-radius: 10px;
            background: var(--input-bg);
            font-size: 0.9rem;
        }
        .topbar-search input:focus { outline: none; border-color: var(--accent); background: #fff; }

        .icon-btn {
            width: 44px; height: 44px; border-radius: 10px;
            border: 1px solid var(--border-light); background: #fff;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-dark); font-size: 1.1rem;
            text-decoration: none;
        }
        .icon-btn:hover { background: var(--input-bg); }

        .content-area { padding: 28px 32px; flex: 1; }

        /* ===== Shared components ===== */
        .page-title { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.7rem; margin-bottom: 4px; }
        .page-subtitle { color: var(--text-muted); font-size: 0.95rem; margin-bottom: 24px; }

        .link-arrow { color: var(--accent); font-weight: 600; text-decoration: none; font-size: 0.88rem; white-space: nowrap; }
        .link-arrow:hover { text-decoration: underline; }

        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 28px; }
        .stat-card { background: #fff; border: 1px solid var(--border-light); border-radius: 14px; padding: 20px; }
        .stat-card .stat-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 14px; font-size: 1.1rem;
        }
        .stat-card .stat-label { color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px; }
        .stat-card .stat-value { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.5rem; }

        @media (max-width: 1199px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 575px) { .stat-grid { grid-template-columns: 1fr; } }

        .welcome-banner {
            background: linear-gradient(135deg, var(--bg-dark) 0%, #2c3550 100%);
            border-radius: 18px; color: #fff; padding: 36px;
            display: flex; align-items: center; justify-content: space-between; gap: 24px;
            margin-bottom: 28px; overflow: hidden;
        }
        .welcome-banner .eyebrow { font-size: 0.78rem; letter-spacing: 0.08em; font-weight: 700; color: rgba(255,255,255,0.55); margin-bottom: 8px; }
        .welcome-banner h2 { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.6rem; margin-bottom: 12px; max-width: 480px; }
        .welcome-banner p { color: rgba(255,255,255,0.65); max-width: 480px; margin-bottom: 20px; }
        .welcome-visual {
            flex-shrink: 0; width: 160px; height: 140px; border-radius: 14px;
            background: linear-gradient(135deg, var(--accent) 0%, #6c2b3f 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; color: rgba(255,255,255,0.8);
        }
        @media (max-width: 767px) { .welcome-banner { flex-direction: column; } .welcome-visual { width: 100%; height: 100px; } }

        .btn-cta, .btn-cta-outline {
            border-radius: 10px; padding: 12px 22px; font-weight: 600; font-size: 0.92rem;
            text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            border: none; cursor: pointer;
        }
        .btn-cta { background: var(--accent); color: #fff; }
        .btn-cta:hover { background: var(--accent-dark); color: #fff; }
        .btn-cta-outline { border: 1px solid var(--accent); color: var(--accent); background: #fff; }
        .btn-cta-outline:hover { background: var(--accent); color: #fff; }

        .section-block { background: #fff; border: 1px solid var(--border-light); border-radius: 16px; padding: 24px; margin-bottom: 28px; }
        .section-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; }
        .section-header h3 { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.15rem; margin: 0; }
        .section-header p { color: var(--text-muted); font-size: 0.88rem; margin: 2px 0 0; }

        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; white-space: nowrap; }
        .status-pending { background: #fdf3d9; color: #a9762b; }
        .status-success { background: #dff3e6; color: #1f9d55; }
        .status-failed  { background: #fbe1e6; color: #c0294a; }

        .order-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .order-table th {
            text-align: left; font-size: 0.75rem; letter-spacing: 0.06em; text-transform: uppercase;
            color: var(--text-muted); font-weight: 600; padding: 10px 12px; border-bottom: 1px solid var(--border-light);
            white-space: nowrap;
        }
        .order-table td { padding: 14px 12px; border-bottom: 1px solid var(--border-light); font-size: 0.92rem; vertical-align: middle; }
        .order-table tr:last-child td { border-bottom: none; }
        .order-thumb { width: 42px; height: 56px; border-radius: 6px; object-fit: cover; background: var(--input-bg); flex-shrink: 0; }
        .order-ebook { display: flex; align-items: center; gap: 12px; }
        .order-ebook-title { font-weight: 600; font-size: 0.92rem; }
        .order-ebook-author { font-size: 0.8rem; color: var(--text-muted); }
        .btn-table-action {
            border: 1px solid var(--border-light); background: #fff; border-radius: 8px;
            width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;
            color: var(--accent); text-decoration: none; margin-right: 4px;
        }
        .btn-table-action:hover { background: var(--input-bg); }

        .ebook-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 18px; }
        @media (max-width: 1199px) { .ebook-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 767px) { .ebook-grid { grid-template-columns: repeat(2, 1fr); } }

        .mini-ebook-cover { aspect-ratio: 3 / 4; border-radius: 10px; overflow: hidden; margin-bottom: 10px; background: var(--input-bg); }
        .mini-ebook-cover img { width: 100%; height: 100%; object-fit: cover; }
        .mini-ebook-cover .placeholder {
            width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--bg-dark), var(--accent));
            color: #fff; font-weight: 600; font-size: 0.8rem; text-align: center; padding: 12px;
            font-family: 'Poppins', sans-serif; line-height: 1.3;
        }
        .mini-ebook-title { font-weight: 600; font-size: 0.9rem; display: block; color: var(--text-dark); text-decoration: none; margin-bottom: 2px; }
        .mini-ebook-title:hover { color: var(--accent); }
        .mini-ebook-author { font-size: 0.8rem; color: var(--text-muted); margin-bottom: 4px; }
        .mini-ebook-price { font-weight: 700; color: var(--accent); font-size: 0.9rem; }
        .promo-badge {
            background: var(--accent); color: #fff; font-size: 0.68rem; font-weight: 700;
            padding: 2px 6px; border-radius: 4px; margin-left: 4px; vertical-align: middle;
        }

        /* ===== Footer ===== */
        .dashboard-footer {
            background: #fff; border-top: 1px solid var(--border-light);
            padding: 20px 32px; display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 12px; font-size: 0.85rem; color: var(--text-muted);
        }
        .dashboard-footer .footer-brand { color: var(--accent); font-weight: 700; font-family: 'Poppins', sans-serif; }
        .dashboard-footer a { color: var(--text-muted); text-decoration: none; margin-left: 16px; }
        .dashboard-footer a:hover { color: var(--accent); }

        @media (max-width: 991px) {
            .sidebar { position: fixed; left: -260px; transition: left .2s ease; }
            .sidebar.show { left: 0; }
            .sidebar-toggle { display: flex; }
            .topbar-search { max-width: none; }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="dashboard-wrapper">

        {{-- ===== Sidebar ===== --}}
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div style="font-size:1.2rem; font-weight:700;">Admin Panel</div>
                <div style="font-size:0.75rem; color:rgba(255,255,255,0.5); font-weight:400; margin-top:2px;">Management Console</div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
                <a href="{{ route('admin.user.index') }}" class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Users
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                    <i class="bi bi-tag"></i> Kategori
                </a>
                <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line"></i> Laporan
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('home') }}" class="btn-browse"><i class="bi bi-house"></i> Lihat Toko</a>
                <div class="user-mini">
                    <div class="avatar-circle">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div>
                        <strong>{{ Auth::user()->name }}</strong>
                        <span>Admin</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn" title="Logout"><i class="bi bi-box-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ===== Main area ===== --}}
        <div class="main-area">
            <header class="topbar">
                <button class="sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>

                <div class="topbar-search">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search data...">
                </div>

                <a href="#" class="icon-btn" title="Notifikasi"><i class="bi bi-bell"></i></a>
            </header>

            <main class="content-area">
                @yield('content')
            </main>

            <footer class="dashboard-footer">
                <span class="footer-brand">EbookStore</span>
                <div>
                    &copy; {{ date('Y') }} EbookStore. All rights reserved.
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Help Center</a>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => sidebar.classList.toggle('show'));
        }
    </script>
    @stack('scripts')
</body>
</html>