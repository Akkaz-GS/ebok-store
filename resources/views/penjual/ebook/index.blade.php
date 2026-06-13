@extends('layouts.penjual')
@section('title', 'Ebook Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Ebook Saya</h4>
        <p class="text-muted small mb-0">Kelola semua ebook yang kamu jual</p>
    </div>
    <a href="{{ route('penjual.ebook.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-lg"></i> Tambah Ebook
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ebooks as $ebook)
                <tr>
                    <td>
                        @if($ebook->cover)
                            <img src="{{ Storage::url($ebook->cover) }}" width="50" height="65"
                                 class="rounded" style="object-fit:cover">
                        @else
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                 style="width:50px;height:65px;font-size:20px">📚</div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $ebook->title }}</div>
                        <div class="text-muted small">{{ Str::limit($ebook->description, 50) }}</div>
                    </td>
                    <td>{{ $ebook->category->name }}</td>
                    <td>Rp {{ number_format($ebook->price, 0, ',', '.') }}</td>
                    <td>
                        @if($ebook->status === 'aktif')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Non-aktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('penjual.ebook.edit', $ebook) }}"
                           class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('penjual.ebook.destroy', $ebook) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus ebook ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <div class="fs-1">📚</div>
                        Belum ada ebook. <a href="{{ route('penjual.ebook.create') }}">Tambah sekarang →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $ebooks->links() }}</div>
@endsection