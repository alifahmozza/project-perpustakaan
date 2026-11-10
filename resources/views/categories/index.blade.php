@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Kategori</span>
@endsection

@section('hero')
    <div class="hero-top">
        <div>
            <h1>Kategori buku</h1>
            <div class="meta"><span>{{ $categories->total() }} kategori untuk mengelompokkan koleksi</span></div>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-dark">
            <svg class="i" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Tambah kategori
        </a>
    </div>
@endsection

@section('content')
    @if ($categories->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama kategori</th>
                        <th>Deskripsi</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <a href="{{ route('books.index', ['category' => $category->id]) }}" class="text-link">{{ $category->nama_kategori }}</a>
                            </td>
                            <td class="muted">{{ $category->deskripsi ?? '-' }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="icon-btn" title="Edit kategori" aria-label="Edit {{ $category->nama_kategori }}">
                                        <svg class="i" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    </a>
                                    <form class="inline" action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn danger" title="Hapus kategori" aria-label="Hapus {{ $category->nama_kategori }}">
                                            <svg class="i" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $categories->links() }}
    @else
        <div class="empty-state">
            <p>Belum ada kategori</p>
            <span>Buat kategori pertama untuk mengelompokkan buku.</span><br>
            <a href="{{ route('categories.create') }}" class="btn">Tambah kategori</a>
        </div>
    @endif
@endsection