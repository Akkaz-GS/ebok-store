@extends('layouts.admin')
@section('title', 'Edit User')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Edit User — {{ $user->name }}</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:560px">
    <div class="card-body p-4">
        <form action="{{ route('admin.user.update', $user) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Role</label>
                <select name="role" class="form-select">
                    <option value="pembeli"  {{ $user->role === 'pembeli'  ? 'selected' : '' }}>Pembeli</option>
                    <option value="penjual"  {{ $user->role === 'penjual'  ? 'selected' : '' }}>Penjual</option>
                    <option value="admin"    {{ $user->role === 'admin'    ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <hr>
            <p class="text-muted small mb-3">Kosongkan password jika tidak ingin mengubah</p>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password Baru</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection