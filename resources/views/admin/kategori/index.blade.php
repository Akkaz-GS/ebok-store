@extends('layouts.admin')
@section('title', 'Kelola Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Kelola Kategori</h4>
        <p class="text-muted small mb-0">Manajemen kategori ebook</p>
    </div>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-lg"></i> Tambah Kategori
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width:600px">
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Nama Kategori</th><th>Slug</th><th>Jumlah Ebook</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td><span class="fw-semibold">{{ $cat->name }}</span></td>
                    <td><code>{{ $cat->slug }}</code></td>
                    <td><span class="badge bg-primary">{{ $cat->ebooks_count }}</span></td>
                    <td>
                        <a href="{{ route('admin.kategori.edit', $cat) }}"
                           class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.kategori.destroy', $cat) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada kategori</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $categories->links() }}</div>
@endsection