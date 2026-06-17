@extends('layouts.admin')

@section('title', 'User Management - Admin Panel')

@section('content')

{{--
    DATA YANG DIBUTUHKAN DI UserController@index:
    - $users         : User::latest()->paginate(10) — bisa difilter role/status via request
    - $totalUsers    : User::count()
    - $totalPenjual  : User::where('role','penjual')->count()
    - $totalPembeli  : User::where('role','pembeli')->count()
    - $newThisWeek   : User::where('created_at','>=',now()->startOfWeek())->count()
--}}

<div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
    <div>
        <h2 class="page-title">User Management</h2>
        <p class="page-subtitle mb-0">Monitor, kelola, dan verifikasi pengguna marketplace.</p>
    </div>
    <a href="{{ route('admin.user.create') }}" class="btn-cta">
        <i class="bi bi-person-plus"></i> Add New User
    </a>
</div>

{{-- Stat Cards --}}
<div class="stat-grid mb-4" style="grid-template-columns:repeat(4,1fr);">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(99,102,241,0.1);color:#6366f1;"><i class="bi bi-people"></i></div>
        <div class="stat-label">Total Users</div>
        <div class="stat-value">{{ number_format($totalUsers) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(251,191,36,0.12);color:#d97706;"><i class="bi bi-shop"></i></div>
        <div class="stat-label">Active Sellers</div>
        <div class="stat-value">{{ number_format($totalPenjual) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(163,37,63,0.1);color:var(--accent);"><i class="bi bi-shield-check"></i></div>
        <div class="stat-label">Verified Buyers</div>
        <div class="stat-value">{{ number_format($totalPembeli) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#dff3e6;color:#1f9d55;"><i class="bi bi-graph-up-arrow"></i></div>
        <div class="stat-label">New This Week</div>
        <div class="stat-value" style="color:#1f9d55;">+{{ $newThisWeek }}</div>
    </div>
</div>

<div class="section-block">
    {{-- Filter Tabs & Search --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div class="d-flex gap-2 flex-wrap">
            @foreach ([
                ['label'=>'All Users', 'value'=>''],
                ['label'=>'Buyers',    'value'=>'pembeli'],
                ['label'=>'Sellers',   'value'=>'penjual'],
                ['label'=>'Admins',    'value'=>'admin'],
            ] as $tab)
                <a href="{{ route('admin.user.index', ['role' => $tab['value']]) }}"
                   style="padding:8px 18px;border-radius:8px;font-weight:600;font-size:0.88rem;text-decoration:none;
                   {{ request('role') === $tab['value'] ? 'background:var(--accent);color:#fff;' : 'background:var(--input-bg);color:var(--text-dark);' }}">
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>
        <form method="GET" action="{{ route('admin.user.index') }}" class="d-flex gap-2">
            @if(request('role'))
                <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
            <div style="position:relative;">
                <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama atau email..."
                       style="padding:9px 12px 9px 36px;border:1px solid var(--border-light);border-radius:8px;background:var(--input-bg);font-size:0.88rem;width:240px;">
            </div>
            <button type="submit" class="btn-cta" style="padding:9px 18px;font-size:0.88rem;">Cari</button>
        </form>
    </div>

    {{-- Table --}}
    @if ($users->isEmpty())
        <p class="text-muted text-center py-4">Tidak ada user ditemukan.</p>
    @else
        <div class="table-responsive">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>User Details</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Join Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:40px;height:40px;border-radius:50%;background:var(--input-bg);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;flex-shrink:0;color:var(--text-dark);">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;font-size:0.92rem;">{{ $user->name }}</div>
                                        <div style="font-size:0.8rem;color:var(--text-muted);">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $roleStyle = match($user->role) {
                                        'admin'   => 'background:#e8eaff;color:#4f46e5;',
                                        'penjual' => 'background:#fdf3d9;color:#a9762b;',
                                        default   => 'background:#f0f0f8;color:#555;',
                                    };
                                @endphp
                                <span class="status-badge" style="{{ $roleStyle }}">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td>
                                <span class="status-badge status-success">
                                    <span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#1f9d55;margin-right:5px;"></span>Aktif
                                </span>
                            </td>
                            <td style="font-size:0.88rem;">{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-table-action" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.user.destroy', $user->id) }}"
                                          onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-table-action" title="Hapus" style="color:#c0294a;border:none;background:#fff;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
            <span style="font-size:0.88rem;color:var(--text-muted);">
                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ number_format($users->total()) }} results
            </span>
            {{ $users->withQueryString()->links() }}
        </div>
    @endif
</div>

@endsection