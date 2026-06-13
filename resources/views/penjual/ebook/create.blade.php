@extends('layouts.penjual')
@section('title', 'Tambah Ebook')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('penjual.ebook.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">Tambah Ebook Baru</h4>
        <p class="text-muted small mb-0">Isi detail ebook yang ingin kamu jual</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('penjual.ebook.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Ebook <span class="text-danger">*</span></label>
                <input type="text" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}"
                       placeholder="Contoh: Panduan Lengkap Laravel 11">
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="price"
                               class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', 0) }}" min="0">
                    </div>
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                <textarea name="description" rows="5"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Jelaskan isi ebook, untuk siapa, dan apa yang akan dipelajari...">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cover Ebook</label>
                    <input type="file" name="cover" accept="image/*"
                           class="form-control @error('cover') is-invalid @enderror">
                    <div class="form-text">JPG/PNG · Maks 2MB</div>
                    @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">File Ebook (PDF) <span class="text-danger">*</span></label>
                    <input type="file" name="file" accept=".pdf"
                           class="form-control @error('file') is-invalid @enderror">
                    <div class="form-text">Format PDF · Maks 50MB · Tersimpan aman (private)</div>
                    @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select" style="max-width:280px">
                    <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>
                        Aktif (langsung terlihat pembeli)
                    </option>
                    <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>
                        Non-aktif (simpan sebagai draft)
                    </option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-danger px-4">
                    <i class="bi bi-save"></i> Simpan Ebook
                </button>
                <a href="{{ route('penjual.ebook.index') }}" class="btn btn-outline-secondary px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection