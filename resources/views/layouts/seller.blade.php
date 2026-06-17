<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Suite') — EbookStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #2c3347;
            --sidebar-width: 193px;
            --primary: #c0392b;
            --primary-hover: #a93226;
            --primary-light: #fdf2f1;
            --border: #e5e7eb;
            --card-radius: 8px;
            --text-muted: #6b7280;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f4f6f9;
            margin: 0;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 18px 16px 14px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand .brand-name {
            color: #fff;
            font-size: 1.05rem;
            font-weight: 700;
            margin: 0;
        }
        .sidebar-brand .brand-sub {
            color: rgba(255,255,255,.4);
            font-size: .7rem;
            margin: 0;
        }

        .sidebar-nav {
            padding: 10px 0;
            flex: 1;
        }
        .sidebar-nav .nav-item { margin: 1px 10px; }
        .sidebar-nav .nav-link {
            color: rgba(255,255,255,.6);
            font-size: .83rem;
            font-weight: 500;
            padding: 9px 12px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            transition: all .15s;
        }
        .sidebar-nav .nav-link:hover { color: #fff; background: rgba(255,255,255,.07); }
        .sidebar-nav .nav-link.active { color: #fff; background: var(--primary); }
        .sidebar-nav .nav-link i { font-size: .95rem; width: 16px; text-align: center; }

        .btn-add-ebook {
            margin: 0 10px 12px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 9px;
            font-size: .82rem;
            font-weight: 600;
            width: calc(100% - 20px);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            transition: background .15s;
        }
        .btn-add-ebook:hover { background: var(--primary-hover); color: #fff; }

        /* User info bottom sidebar */
        .sidebar-user {
            padding: 12px 14px;
            border-top: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-user .user-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            font-size: .75rem;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-user .user-name {
            color: #fff;
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.2;
        }
        .sidebar-user .user-role {
            color: rgba(255,255,255,.4);
            font-size: .7rem;
        }
        .sidebar-user .logout-btn {
            margin-left: auto;
            color: rgba(255,255,255,.4);
            font-size: .9rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: color .15s;
        }
        .sidebar-user .logout-btn:hover { color: #fff; }

        /* ── TOPBAR ── */
        .topbar {
            margin-left: var(--sidebar-width);
            height: 56px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 20px;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar .search-wrap {
            position: relative;
            flex: 1;
            max-width: 340px;
        }
        .topbar .search-wrap i {
            position: absolute;
            left: 11px; top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: .85rem;
        }
        .topbar .search-wrap input {
            width: 100%;
            padding: 7px 12px 7px 32px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: .82rem;
            background: #f9fafb;
            color: #374151;
        }
        .topbar .search-wrap input:focus {
            outline: none;
            border-color: #9ca3af;
            background: #fff;
        }
        .topbar .bell-btn {
            margin-left: auto;
            width: 34px; height: 34px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            color: #6b7280;
            font-size: .95rem;
            cursor: pointer;
        }
        .topbar .bell-btn:hover { background: #f3f4f6; }

        /* ── MAIN ── */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 24px;
            min-height: calc(100vh - 56px);
        }

        /* ── STAT CARDS ── */
        .stat-card {
            background: #fff;
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            padding: 20px;
            height: 100%;
        }
        .stat-card .stat-icon-wrap {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            margin-bottom: 14px;
        }
        .stat-card .stat-change {
            font-size: .72rem;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .stat-card .stat-label {
            font-size: .78rem;
            color: var(--text-muted);
            margin-bottom: 4px;
        }
        .stat-card .stat-value {
            font-size: 1.6rem;
            font-weight: 700;
            color: #111;
            line-height: 1.1;
        }
        .icon-pink   { background: #fce7f3; color: #db2777; }
        .icon-blue   { background: #dbeafe; color: #2563eb; }
        .icon-yellow { background: #fef3c7; color: #d97706; }
        .icon-green  { background: #dcfce7; color: #16a34a; }
        .icon-red    { background: var(--primary-light); color: var(--primary); }
        .icon-purple { background: #ede9fe; color: #7c3aed; }

        .text-up   { color: #16a34a; }
        .text-down { color: var(--primary); }

        /* ── CONTENT CARD ── */
        .content-card {
            background: #fff;
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .content-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }
        .content-card-header h5 {
            font-size: .95rem;
            font-weight: 700;
            margin: 0;
            color: #111;
        }
        .content-card-header .sub {
            font-size: .76rem;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        /* ── TABLE ── */
        .table-custom { margin: 0; }
        .table-custom thead th {
            background: #f9fafb;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            padding: 10px 16px;
        }
        .table-custom tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
            font-size: .83rem;
            color: #374151;
        }
        .table-custom tbody tr:last-child td { border-bottom: none; }
        .table-custom tbody tr:hover td { background: #fafafa; }

        /* ── BADGES ── */
        .badge-pill {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 600;
        }
        .badge-aktif     { background: #dcfce7; color: #15803d; }
        .badge-nonaktif  { background: #f3f4f6; color: #6b7280; }
        .badge-selesai   { background: #dcfce7; color: #15803d; }
        .badge-pending   { background: #fef9c3; color: #a16207; }
        .badge-lunas     { background: #dcfce7; color: #15803d; }
        .badge-ditolak   { background: #fee2e2; color: #b91c1c; }
        .badge-penjual   { background: #fef3c7; color: #92400e; }
        .badge-pembeli   { background: #dbeafe; color: #1e40af; }

        /* ── BUTTONS ── */
        .btn-primary-red {
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 7px 14px;
            font-size: .8rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            transition: background .15s;
        }
        .btn-primary-red:hover { background: var(--primary-hover); color: #fff; }
        .btn-outline-gray {
            background: #fff;
            color: #374151;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 7px 14px;
            font-size: .8rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            transition: all .15s;
        }
        .btn-outline-gray:hover { background: #f3f4f6; color: #111; }

        /* ── LINK RED ── */
        .link-red {
            color: var(--primary);
            font-size: .8rem;
            font-weight: 600;
            text-decoration: none;
        }
        .link-red:hover { text-decoration: underline; color: var(--primary-hover); }

        /* ── PAGE HEADER ── */
        .page-header { margin-bottom: 20px; }
        .page-header h4 { font-size: 1.2rem; font-weight: 700; margin: 0 0 3px; color: #111; }
        .page-header p  { font-size: .78rem; color: var(--text-muted); margin: 0; }

        /* ── ALERT ── */
        .alert { border-radius: var(--card-radius); font-size: .83rem; }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <p class="brand-name">Seller Suite</p>
        <p class="brand-sub">Management Console</p>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('penjual.dashboard') }}"
                   class="nav-link {{ request()->routeIs('penjual.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('penjual.library') }}"
                   class="nav-link {{ request()->routeIs('penjual.library') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark"></i> My Library
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('penjual.inventory') }}"
                   class="nav-link {{ request()->routeIs('penjual.inventory') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Inventory
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('penjual.sales') }}"
                   class="nav-link {{ request()->routeIs('penjual.sales') ? 'active' : '' }}">
                    <i class="bi bi-graph-up-arrow"></i> Sales Tracking
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('penjual.laporan') }}"
                   class="nav-link {{ request()->routeIs('penjual.laporan') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line"></i> Laporan
                </a>
            </li>
        </ul>
    </nav>

    <a href="{{ route('penjual.ebook.create') }}" class="btn-add-ebook">
        <i class="bi bi-plus-circle"></i> Tambah Ebook
    </a>

    {{-- User info --}}
    <div class="sidebar-user">
        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 2)) }}
        </div>
        <div>
            <div class="user-name">{{ auth()->user()->name ?? 'Penjual' }}</div>
            <div class="user-role">Penjual</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="logout-btn" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>
</aside>

{{-- TOPBAR --}}
<div class="topbar">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="@yield('search-placeholder', 'Cari ebook, pesanan...')">
    </div>
    <button class="bell-btn"><i class="bi bi-bell"></i></button>
</div>

{{-- MAIN --}}
<main class="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
