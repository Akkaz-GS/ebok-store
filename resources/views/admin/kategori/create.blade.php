@extends('layouts.admin')
@section('title', 'Tambah Kategori')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Tambah Kategori Baru</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:400px">
    <div class="card-body p-4">
        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-semibold">Nama Kategori</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="Contoh: Teknologi" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">Slug akan dibuat otomatis</div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-danger px-4">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection