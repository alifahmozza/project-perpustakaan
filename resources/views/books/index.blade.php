@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('breadcrumb')
    <a href="{{ url('/dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Buku</span>
@endsection

@section('hero')
    <div class="hero-top">
        <div>
            <h1>Koleksi buku</h1>
            <div class="meta">
                <span>
                    <svg class="i" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    {{ $books->total() }} judul
                </span>
            </div>
        </div>
        <a href="{{ route('books.create') }}" class="btn btn-dark">
            <svg class="i" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Tambah buku
        </a>
    </div>

    @if (isset($categories) && $categories->count() > 0)
        <div class="tags">
            @foreach ($categories as $category)
                <a href="{{ route('books.index', ['category' => $category->id]) }}" class="tag">{{ $category->nama_kategori }}</a>
            @endforeach
        </div>
    @endif
@endsection

@section('content')
    @if ($books->count() > 0)
        <div class="book-grid">
            @foreach ($books as $book)
                <article class="book">
                    <a href="{{ route('books.show', $book->id) }}" class="book-link">
                        @include('books.cover', ['book' => $book])
                        <h3 class="book-title">{{ $book->judul }}</h3>
                    </a>
                    <div class="book-author">{{ $book->penulis }}</div>

                    <div class="book-foot">
                        <span class="pill">{{ $book->category->nama_kategori ?? 'Tanpa kategori' }}</span>
                        <span class="stock {{ $book->stok > 0 ? 'ok' : 'bad' }}">
                            {{ $book->stok > 0 ? 'Stok ' . $book->stok : 'Habis' }}
                        </span>
                    </div>

                    <div class="book-actions">
                        @if ($book->stok > 0)
                            <a href="{{ route('loans.create', ['book_id' => $book->id]) }}" class="btn btn-sm">Pinjam</a>
                        @else
                            <span class="btn btn-sm btn-disabled">Tidak tersedia</span>
                        @endif
                        <a href="{{ route('books.edit', $book->id) }}" class="icon-btn" title="Edit buku" aria-label="Edit {{ $book->judul }}">
                            <svg class="i" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        </a>
                        <form class="inline" action="{{ route('books.destroy', $book->id) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus buku ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn danger" title="Hapus buku" aria-label="Hapus {{ $book->judul }}">
                                <svg class="i" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        <div style="margin-top: 32px;">
            {{ $books->links() }}
        </div>
    @else
        <div class="empty-state">
            <p>Belum ada buku di koleksi</p>
            <span>Tambahkan buku pertama beserta sampulnya.</span><br>
            <a href="{{ route('books.create') }}" class="btn">Tambah buku</a>
        </div>
    @endif
@endsection