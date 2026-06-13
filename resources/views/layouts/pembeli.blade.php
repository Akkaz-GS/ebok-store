<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — EbookStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f7f4; }
        .sidebar { width: 230px; min-height: 100vh; background: #1a1a2e; position: fixed; top: 0; left: 0; z-index: 100; display: flex; flex-direction: column; padding: 24px 16px; }
        .sidebar-logo { font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 4px; }
        .sidebar-logo span { color: #e94560; }
        .sidebar-user { font-size: 12px; color: rgba(255,255,255,.5); margin-bottom: 20px; }
        .sidebar .nav-link { color: rgba(255,255,255,.7); border-radius: 8px; padding: 10px 12px; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 10px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,.1); color: #fff; }
        .sidebar .nav-link.active { background: #e94560; color: #fff; }
        .main-content { margin-left: 230px; padding: 32px; min-height: 100vh; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-logo">📚 Ebook<span>Store</span></div>
    <div class="sidebar-user">👤 {{ auth()->user()->name }}</div>
    <hr style="border-color:rgba(255,255,255,.1)">
    <nav class="nav flex-column gap-1 flex-grow-1">
        <a href="{{ route('pembeli.dashboard') }}"
           class="nav-link {{ request()->routeIs('pembeli.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('home') }}" class="nav-link">
            <i class="bi bi-shop"></i> Katalog Ebook
        </a>
        <a href="{{ route('pembeli.order.index') }}"
           class="nav-link {{ request()->routeIs('pembeli.order.index') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Riwayat Pembelian
        </a>
    </nav>
    <hr style="border-color:rgba(255,255,255,.1)">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-sm btn-outline-danger w-100">
            <i class="bi bi-box-arrow-left"></i> Logout
        </button>
    </form>
</div>

<div class="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>