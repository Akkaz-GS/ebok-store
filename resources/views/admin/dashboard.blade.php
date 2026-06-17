@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')

@section('content')

{{--
    DATA YANG DIBUTUHKAN DI AdminController@dashboard:
    - $totalUsers    : User::count()
    - $totalOrders   : Order::count()
    - $totalRevenue  : Order::whereIn('status',['dibayar','selesai'])->sum('total_price')
    - $activePromos  : Promo::count() (atau where aktif)
    - $recentUsers   : User::latest()->take(5)->get()
    - $orderStats    : ['pending'=>int, 'selesai'=>int, 'ditolak'=>int]
--}}

<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
    <div>
        <h2 class="page-title">Platform Overview</h2>
        <p class="page-subtitle mb-0">Ringkasan performa dan aktivitas marketplace.</p>
    </div>
</div>

{{-- Stat Cards --}}
<div class="stat-grid" style="grid-template-columns: repeat(4,1fr)">
    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="stat-icon" style="background:rgba(99,102,241,0.1);color:#6366f1;"><i class="bi bi-people"></i></div>
            <span style="font-size:0.8rem;font-weight:600;color:#1f9d55;">+12%</span>
        </div>
        <div class="stat-label">Total Users</div>
        <div class="stat-value">{{ number_format($totalUsers) }}</div>
    </div>

    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="stat-icon" style="background:rgba(163,37,63,0.1);color:var(--accent);"><i class="bi bi-receipt"></i></div>
            <span style="font-size:0.8rem;font-weight:600;color:#1f9d55;">+8.4%</span>
        </div>
        <div class="stat-label">Total Transaksi</div>
        <div class="stat-value">{{ number_format($totalOrders) }}</div>
    </div>

    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="stat-icon" style="background:rgba(28,34,48,0.07);color:var(--bg-dark);"><i class="bi bi-cash-stack"></i></div>
            <span style="font-size:0.8rem;font-weight:600;color:#c0294a;">-2.1%</span>
        </div>
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value" style="font-size:1.25rem;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    </div>

    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="stat-icon" style="background:rgba(251,191,36,0.12);color:#d97706;"><i class="bi bi-tag"></i></div>
        </div>
        <div class="stat-label">Promo Aktif</div>
        <div class="stat-value">{{ $activePromos }}</div>
    </div>
</div>

<div class="row g-4">
    {{-- User Terdaftar Terbaru --}}
    <div class="col-lg-7">
        <div class="section-block h-100">
            <div class="section-header">
                <div>
                    <h3>User Terdaftar Terbaru</h3>
                    <p>Pengguna yang baru bergabung di platform.</p>
                </div>
                <a href="{{ route('admin.user.index') }}" class="link-arrow">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentUsers as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle" style="width:36px;height:36px;font-size:0.85rem;background:var(--input-bg);color:var(--text-dark);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;font-size:0.9rem;">{{ $user->name }}</div>
                                        <div style="font-size:0.8rem;color:var(--text-muted);">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $roleColor = match($user->role) {
                                        'admin'   => 'background:#e8eaff;color:#4f46e5;',
                                        'penjual' => 'background:#fdf3d9;color:#a9762b;',
                                        default   => 'background:#dff3e6;color:#1f9d55;',
                                    };
                                @endphp
                                <span class="status-badge" style="{{ $roleColor }}">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td style="font-size:0.88rem;">{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-table-action" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ringkasan Pesanan --}}
    <div class="col-lg-5 d-flex flex-column gap-4">
        <div class="section-block">
            <div class="section-header mb-3">
                <h3>Ringkasan Pesanan</h3>
            </div>
            @php
                $total = array_sum($orderStats);
            @endphp

            <div class="d-flex flex-column gap-3">
                @foreach ([
                    ['label'=>'Selesai',              'key'=>'selesai',              'color'=>'#1f9d55', 'bg'=>'#dff3e6'],
                    ['label'=>'Menunggu Verifikasi',  'key'=>'menunggu_verifikasi',  'color'=>'#a9762b', 'bg'=>'#fdf3d9'],
                    ['label'=>'Ditolak',              'key'=>'ditolak',              'color'=>'#c0294a', 'bg'=>'#fbe1e6'],
                ] as $item)
                    @php $val = $orderStats[$item['key']] ?? 0; $pct = $total > 0 ? round($val/$total*100) : 0; @endphp
                    <div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:0.88rem;">
                            <span style="font-weight:500;">{{ $item['label'] }}</span>
                            <span style="font-weight:700;color:{{ $item['color'] }};">{{ $pct }}%</span>
                        </div>
                        <div style="height:8px;background:var(--input-bg);border-radius:999px;overflow:hidden;">
                            <div style="height:100%;width:{{ $pct }}%;background:{{ $item['color'] }};border-radius:999px;"></div>
                        </div>
                        <div style="font-size:0.8rem;color:var(--text-muted);margin-top:3px;">{{ number_format($val) }} transaksi</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- CTA Laporan --}}
        <div style="background:linear-gradient(135deg,var(--bg-dark) 0%,var(--accent-dark) 100%);border-radius:16px;padding:28px;color:#fff;">
            <h3 style="font-family:'Poppins',sans-serif;font-weight:700;margin-bottom:8px;">Laporan Tahunan</h3>
            <p style="color:rgba(255,255,255,0.65);font-size:0.9rem;margin-bottom:18px;">Unduh laporan performa lengkap platform Anda.</p>
            <a href="{{ route('admin.laporan') }}" class="btn-light-cta">Lihat Laporan <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>

@endsection