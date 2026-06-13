@extends('layouts.penjual')
@section('title', 'Edit Ebook')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('penjual.ebook.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0">Edit Ebook</h4>
        <p class="text-muted small mb-0">{{ $ebook->title }}</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('penjual.ebook.update', $ebook) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Ebook <span class="text-danger">*</span></label>
                <input type="text" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $ebook->title) }}">
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $ebook->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="price" class="form-control"
                               value="{{ old('price', $ebook->price) }}" min="0">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                <textarea name="description" rows="5" class="form-control">{{ old('description', $ebook->description) }}</textarea>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cover Baru</label>
                    @if($ebook->cover)
                        <div class="mb-2">
                            <img src="{{ Storage::url($ebook->cover) }}" height="90"
                                 class="rounded border" style="object-fit:cover">
                            <div class="form-text">Cover saat ini</div>
                        </div>
                    @endif
                    <input type="file" name="cover" accept="image/*" class="form-control">
                    <div class="form-text">Kosongkan jika tidak ingin mengganti</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">File PDF Baru</label>
                    <div class="alert alert-light py-2 px-3 mb-2 small">
                        <i class="bi bi-file-pdf text-danger"></i>
                        File saat ini: <strong>{{ basename($ebook->file) }}</strong>
                    </div>
                    <input type="file" name="file" accept=".pdf" class="form-control">
                    <div class="form-text">Kosongkan jika tidak ingin mengganti</div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select" style="max-width:280px">
                    <option value="aktif"    {{ $ebook->status === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $ebook->status === 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-save"></i> Update Ebook
                </button>
                <a href="{{ route('penjual.ebook.index') }}" class="btn btn-outline-secondary px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection