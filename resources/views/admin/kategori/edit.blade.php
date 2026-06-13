@extends('layouts.admin')
@section('title', 'Edit Kategori')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Edit Kategori</h4>
</div>

<div class="card border-0 shadow-sm" style="max-width:400px">
    <div class="card-body p-4">
        <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="form-label fw-semibold">Nama Kategori</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $kategori->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection