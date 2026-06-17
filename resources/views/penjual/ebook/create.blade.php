@extends('layouts.seller')

@section('title', isset($ebook) ? 'Edit Ebook' : 'Tambah Ebook')
@section('search-placeholder', 'Cari ebook...')

@push('styles')
<style>
    .form-section {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--card-radius);
        margin-bottom: 16px;
    }
    .form-section-header {
        padding: 14px 18px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 9px;
    }
    .form-section-header .sec-icon {
        width: 28px; height: 28px;
        border-radius: 6px;
        background: var(--primary-light);
        display: flex; align-items: center; justify-content: center;
        color: var(--primary); font-size: .85rem;
    }
    .form-section-header h6 {
        margin: 0;
        font-size: .88rem;
        font-weight: 700;
        color: #111;
    }
    .form-section-body { padding: 18px; }

    .form-label { font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
    .form-control, .form-select {
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: .83rem;
        padding: 8px 11px;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(192,57,43,.08);
    }
    .form-control::placeholder { color: #9ca3af; }

    .cover-zone {
        border: 2px dashed #d1d5db;
        border-radius: 7px;
        padding: 24px 16px;
        text-align: center;
        cursor: pointer;
        background: #fafafa;
        transition: all .2s;
        position: relative;
        overflow: hidden;
    }
    .cover-zone:hover { border-color: var(--primary); background: var(--primary-light); }
    .cover-zone input[type=file] {
        position: absolute; inset: 0;
        opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .cover-zone .cz-icon {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: #e5e7eb;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 8px;
        font-size: 1.1rem; color: #9ca3af;
    }
    .cover-zone:hover .cz-icon { background: rgba(192,57,43,.15); color: var(--primary); }

    .upload-opt {
        border: 1px solid var(--border);
        border-radius: 7px;
        padding: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        position: relative;
        cursor: pointer;
        transition: border-color .15s;
    }
    .upload-opt:hover { border-color: var(--primary); }
    .upload-opt input[type=file] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .upload-opt .opt-icon {
        width: 34px; height: 34px;
        border-radius: 6px;
        background: var(--primary-light);
        display: flex; align-items: center; justify-content: center;
        color: var(--primary); font-size: .9rem; flex-shrink: 0;
    }
    .upload-opt .opt-lbl { font-size: .82rem; font-weight: 600; color: #111; }
    .upload-opt .opt-sub { font-size: .71rem; color: #6b7280; }

    .tip-box {
        background: #fef9c3;
        border-radius: 6px;
        padding: 9px 11px;
        font-size: .73rem;
        color: #92400e;
        display: flex; gap: 7px; align-items: flex-start;
        margin-top: 10px;
    }

    .desc-toolbar {
        border: 1px solid #d1d5db;
        border-bottom: none;
        border-radius: 6px 6px 0 0;
        padding: 5px 9px;
        display: flex; gap: 3px;
    }
    .desc-toolbar button {
        width: 26px; height: 24px;
        border: none; background: none;
        border-radius: 4px; cursor: pointer;
        font-size: .8rem; color: #374151;
        display: flex; align-items: center; justify-content: center;
    }
    .desc-toolbar button:hover { background: #f3f4f6; }
    textarea.desc-ta {
        border: 1px solid #d1d5db;
        border-radius: 0 0 6px 6px;
        padding: 9px 11px;
        font-size: .83rem;
        width: 100%;
        min-height: 130px;
        resize: vertical;
    }
    textarea.desc-ta:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(192,57,43,.08); }

    .breadcrumb-bar { font-size:.76rem; color:#6b7280; margin-bottom:14px; }
    .breadcrumb-bar a { color:#6b7280; text-decoration:none; }
    .breadcrumb-bar a:hover { color:var(--primary); }
    .breadcrumb-bar .cur { color:var(--primary); font-weight:600; }
    .breadcrumb-bar .sep { margin:0 5px; }

    .toggle-row {
        display:flex; align-items:center; justify-content:space-between;
        padding-top:12px; border-top:1px solid var(--border); margin-top:12px;
    }
</style>
@endpush

@section('content')
<div class="breadcrumb-bar">
    <a href="{{ route('penjual.dashboard') }}">Dashboard</a>
    <span class="sep">›</span>
    <a href="{{ route('penjual.library') }}">My Library</a>
    <span class="sep">›</span>
    <span class="cur">{{ isset($ebook) ? 'Edit Ebook' : 'Tambah Ebook' }}</span>
</div>

<div class="page-header">
    <h4>{{ isset($ebook) ? 'Edit Ebook' : 'Tambah Ebook Baru' }}</h4>
    <p>Upload dan konfigurasi ebook kamu untuk marketplace</p>
</div>

@if($errors->any())
    <div class="alert alert-danger mb-3">
        <ul class="mb-0 ps-3" style="font-size:.82rem;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<form action="{{ isset($ebook) ? route('penjual.ebook.update', $ebook->id) : route('penjual.ebook.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($ebook)) @method('PUT') @endif

    <div class="row g-3">
        {{-- LEFT --}}
        <div class="col-lg-7">
            {{-- Detail Buku --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="sec-icon"><i class="bi bi-pencil-square"></i></div>
                    <h6>Detail Buku</h6>
                </div>
                <div class="form-section-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control"
                               placeholder="e.g. The Art of Digital Minimalism"
                               value="{{ old('title', $ebook->title ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Penulis</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}"
                               readonly style="background:#f9fafb;">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Deskripsi</label>
                        <div class="desc-toolbar">
                            <button type="button" onclick="wrapText('**')"><b>B</b></button>
                            <button type="button" onclick="wrapText('*')"><i>I</i></button>
                            <button type="button"><i class="bi bi-list-ul"></i></button>
                            <button type="button"><i class="bi bi-link-45deg"></i></button>
                        </div>
                        <textarea name="description" id="descTA" class="desc-ta"
                                  placeholder="Ceritakan isi buku ini...">{{ old('description', $ebook->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kategori & Harga --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="sec-icon"><i class="bi bi-tag"></i></div>
                    <h6>Kategori & Harga</h6>
                </div>
                <div class="form-section-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih kategori</option>
                                @foreach($categories ?? [] as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $ebook->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Harga (IDR) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:.82rem;background:#f9fafb;border-color:#d1d5db;">Rp</span>
                                <input type="number" name="price" class="form-control"
                                       min="0" step="1000"
                                       value="{{ old('price', $ebook->price ?? 0) }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="col-lg-5">
            {{-- Cover --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="sec-icon"><i class="bi bi-image"></i></div>
                    <h6>Cover Buku</h6>
                </div>
                <div class="form-section-body">
                    @if(isset($ebook) && $ebook->cover)
                        <div style="position:relative;margin-bottom:10px;">
                            <img src="{{ asset('storage/'.$ebook->cover) }}" id="coverPreview"
                                 style="width:100%;border-radius:6px;" alt="Cover">
                        </div>
                        <p style="font-size:.74rem;color:#6b7280;">Upload baru untuk mengganti cover.</p>
                        <div class="cover-zone" style="padding:14px;">
                            <input type="file" name="cover" id="coverInput" accept="image/jpeg,image/png"
                                   onchange="previewCover(this)">
                            <span style="font-size:.78rem;color:#6b7280;">Klik untuk ganti cover</span>
                        </div>
                    @else
                        <div class="cover-zone" id="coverZone">
                            <input type="file" name="cover" id="coverInput" accept="image/jpeg,image/png"
                                   onchange="previewCover(this)">
                            <div class="cz-icon"><i class="bi bi-cloud-upload"></i></div>
                            <div style="font-size:.82rem;font-weight:600;color:#374151;margin-bottom:2px;">
                                Klik atau drag cover di sini
                            </div>
                            <div style="font-size:.71rem;color:#9ca3af;">JPG atau PNG (Min 1600×2400px)</div>
                        </div>
                        <img src="" id="coverPreview" style="display:none;width:100%;border-radius:6px;margin-top:8px;">
                    @endif
                    <div class="tip-box">
                        <i class="bi bi-info-circle" style="flex-shrink:0;margin-top:1px;"></i>
                        Cover berkualitas tinggi bisa meningkatkan konversi hingga 40%.
                    </div>
                </div>
            </div>

            {{-- File Ebook --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="sec-icon"><i class="bi bi-file-earmark-pdf"></i></div>
                    <h6>File Ebook</h6>
                </div>
                <div class="form-section-body">
                    @if(isset($ebook) && $ebook->file)
                        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:.78rem;border-radius:6px;">
                            <i class="bi bi-check-circle me-1"></i>File sudah diupload. Upload baru untuk mengganti.
                        </div>
                    @endif

                    <div class="upload-opt">
                        <input type="file" name="file" accept="application/pdf">
                        <div class="opt-icon"><i class="bi bi-file-earmark-pdf"></i></div>
                        <div>
                            <div class="opt-lbl">Upload PDF</div>
                            <div class="opt-sub">Direkomendasikan untuk layout kompleks</div>
                        </div>
                        <i class="bi bi-plus-circle ms-auto" style="color:#9ca3af;"></i>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div style="font-size:.82rem;font-weight:600;color:#374151;">Status Publikasi</div>
                            <div style="font-size:.72rem;color:#9ca3af;margin-top:2px;" id="statusLabel">
                                {{ isset($ebook) && $ebook->status === 'aktif' ? '⬤ AKTIF' : '⬤ DRAFT' }}
                            </div>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="is_active"
                                   id="isActiveSwitch" value="1" role="switch"
                                   {{ old('is_active', isset($ebook) && $ebook->status === 'aktif') ? 'checked' : '' }}
                                   onchange="updateLabel(this)">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <button type="submit" class="btn-primary-red w-100 justify-content-center mb-2"
                    style="padding:11px;">
                <i class="bi bi-save"></i>
                {{ isset($ebook) ? 'Simpan Perubahan' : 'Simpan Ebook' }}
            </button>
            <a href="{{ route('penjual.library') }}"
               class="btn-outline-gray w-100 justify-content-center" style="padding:10px;">
                Batal
            </a>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewCover(input) {
    if (!input.files?.[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('coverPreview');
        const zone    = document.getElementById('coverZone');
        if (preview) { preview.src = e.target.result; preview.style.display = 'block'; }
        if (zone)    zone.style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}
function updateLabel(cb) {
    const lbl = document.getElementById('statusLabel');
    if (lbl) lbl.textContent = cb.checked ? '⬤ AKTIF' : '⬤ DRAFT';
}
function wrapText(wrap) {
    const ta = document.getElementById('descTA');
    const s = ta.selectionStart, e = ta.selectionEnd;
    ta.value = ta.value.slice(0,s) + wrap + ta.value.slice(s,e) + wrap + ta.value.slice(e);
    ta.focus();
    ta.setSelectionRange(s + wrap.length, e + wrap.length);
}
</script>
@endpush
