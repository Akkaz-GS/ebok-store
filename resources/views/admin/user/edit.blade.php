@extends('layouts.admin')

@section('title', isset($user) ? 'Edit User - Admin Panel' : 'Create User - Admin Panel')

@section('content')

{{-- Breadcrumb --}}
<nav style="font-size:0.88rem;color:var(--text-muted);margin-bottom:24px;">
    <a href="{{ route('admin.user.index') }}" style="color:var(--text-muted);text-decoration:none;">Users</a>
    <span class="mx-2">›</span>
    <span style="color:var(--accent);font-weight:600;">
        {{ isset($user) ? 'Edit User' : 'Add New User' }}
    </span>
</nav>

<h2 class="page-title">{{ isset($user) ? 'Edit User Account' : 'Create User Account' }}</h2>
<p class="page-subtitle">{{ isset($user) ? 'Perbarui informasi akun pengguna.' : 'Daftarkan anggota baru ke platform EbookStore.' }}</p>

<div class="section-block" style="max-width:760px;">
    <div style="font-family:'Poppins',sans-serif;font-weight:600;font-size:1rem;margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid var(--border-light);">
        Account Information
    </div>

    <form method="POST"
          action="{{ isset($user) ? route('admin.user.update', $user->id) : route('admin.user.store') }}">
        @csrf
        @if (isset($user))
            @method('PUT')
        @endif

        @if ($errors->any())
            <div class="alert alert-danger small mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Full Name --}}
        <div class="mb-4">
            <label style="font-size:0.72rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;display:block;margin-bottom:6px;">
                Full Name
            </label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                   placeholder="e.g. Jonathan Doe"
                   style="width:100%;height:48px;padding:0 16px;border:1px solid var(--border-light);border-radius:8px;background:var(--input-bg);font-size:0.92rem;"
                   required>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label style="font-size:0.72rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;display:block;margin-bottom:6px;">
                Email Address
            </label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                   placeholder="jonathan.doe@example.com"
                   style="width:100%;height:48px;padding:0 16px;border:1px solid var(--border-light);border-radius:8px;background:var(--input-bg);font-size:0.92rem;"
                   required>
        </div>

        {{-- Role --}}
        <div class="mb-4">
            <label style="font-size:0.72rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;display:block;margin-bottom:6px;">
                Account Role
            </label>
            <select name="role"
                    style="width:100%;height:48px;padding:0 16px;border:1px solid var(--border-light);border-radius:8px;background:var(--input-bg);font-size:0.92rem;appearance:auto;">
                @foreach (['pembeli' => 'Buyer (Pembeli)', 'penjual' => 'Seller (Penjual)', 'admin' => 'Admin'] as $val => $label)
                    <option value="{{ $val }}" {{ old('role', $user->role ?? '') === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Password (required only on create) --}}
        <div class="row g-3 mb-4">
            <div class="col-6">
                <label style="font-size:0.72rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;display:block;margin-bottom:6px;">
                    Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}
                </label>
                <div style="position:relative;">
                    <input type="password" name="password" id="pw1"
                           placeholder="••••••••"
                           style="width:100%;height:48px;padding:0 44px 0 16px;border:1px solid var(--border-light);border-radius:8px;background:var(--input-bg);font-size:0.92rem;"
                           {{ isset($user) ? '' : 'required' }}>
                    <i class="bi bi-eye" onclick="toggle('pw1',this)"
                       style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--text-muted);"></i>
                </div>
            </div>
            <div class="col-6">
                <label style="font-size:0.72rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;display:block;margin-bottom:6px;">
                    Confirm Password
                </label>
                <div style="position:relative;">
                    <input type="password" name="password_confirmation" id="pw2"
                           placeholder="••••••••"
                           style="width:100%;height:48px;padding:0 44px 0 16px;border:1px solid var(--border-light);border-radius:8px;background:var(--input-bg);font-size:0.92rem;"
                           {{ isset($user) ? '' : 'required' }}>
                    <i class="bi bi-eye" onclick="toggle('pw2',this)"
                       style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--text-muted);"></i>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div style="padding-top:20px;border-top:1px solid var(--border-light);display:flex;gap:12px;justify-content:flex-end;">
            <a href="{{ route('admin.user.index') }}" class="btn-cta-outline" style="padding:10px 24px;">
                CANCEL
            </a>
            <button type="submit" class="btn-cta" style="padding:10px 24px;">
                <i class="bi bi-floppy"></i> {{ isset($user) ? 'UPDATE USER' : 'SAVE USER' }}
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    function toggle(id, icon) {
        const input = document.getElementById(id);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.classList.toggle('bi-eye', !isHidden);
        icon.classList.toggle('bi-eye-slash', isHidden);
    }
</script>
@endpush