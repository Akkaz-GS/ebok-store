@extends('layouts.admin')
@section('title', 'Kelola User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Kelola User</h4>
        <p class="text-muted small mb-0">Manajemen semua akun pengguna</p>
    </div>
    <a href="{{ route('admin.user.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-lg"></i> Tambah User
    </a>
</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Cari nama atau email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select form-select-sm">
                    <option value="">Semua Role</option>
                    <option value="pembeli"  {{ request('role') === 'pembeli'  ? 'selected' : '' }}>Pembeli</option>
                    <option value="penjual"  {{ request('role') === 'penjual'  ? 'selected' : '' }}>Penjual</option>
                    <option value="admin"    {{ request('role') === 'admin'    ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-danger btn-sm w-100">Filter</button>
            </div>
            @if(request('search') || request('role'))
            <div class="col-md-2">
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary btn-sm w-100">Reset</a>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-muted small">{{ $users->firstItem() + $loop->index }}</td>
                    <td><span class="fw-semibold">{{ $user->name }}</span></td>
                    <td class="text-muted small">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @elseif($user->role === 'penjual')
                            <span class="badge" style="background:#ede9fe;color:#5b21b6">Penjual</span>
                        @else
                            <span class="badge bg-info">Pembeli</span>
                        @endif
                    </td>
                    <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.user.edit', $user) }}"
                           class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.user.destroy', $user) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">Tidak ada user ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $users->withQueryString()->links() }}</div>
@endsection