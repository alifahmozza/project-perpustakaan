@extends('layouts.app')

@section('title', 'Dashboard — Perpustakaan Digital Kampus')

@section('hero')
    <div class="hero-top">
        <div>
            <div class="hero-sub">
                <span class="avatar">P</span>
                Perpustakaan Digital Kampus
            </div>
            <h1>Selamat datang{{ auth()->check() ? ', ' . Str::before(auth()->user()->name, ' ') : '' }}</h1>
            <div class="meta">
                <span>
                    <svg class="i" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    {{ $stats['total_buku'] }} buku
                </span>
                <span>
                    <svg class="i" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    {{ $stats['total_anggota'] }} anggota
                </span>
                <span>
                    <svg class="i" viewBox="0 0 24 24"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/></svg>
                    {{ $stats['peminjaman_aktif'] }} peminjaman aktif
                </span>
            </div>
        </div>

        <div class="hero-actions">
            <a href="{{ route('loans.report') }}" class="btn btn-dark">Laporan peminjaman</a>
            <a href="{{ route('books.index') }}" class="btn btn-dark">Semua buku</a>
        </div>
    </div>

    @if (isset($categories) && $categories->count() > 0)
        <div class="tags">
            @foreach ($categories->take(4) as $category)
                <a href="{{ route('books.index', ['category' => $category->id]) }}" class="tag">{{ $category->nama_kategori }}</a>
            @endforeach
        </div>
    @endif
@endsection

@section('content')
    <div class="cols">
        {{-- Buku terbaru --}}
        <section>
            <div class="section-title">
                <h2>Buku terbaru</h2>
                <a href="{{ route('books.index') }}">Lihat semua</a>
            </div>

            @if (isset($latestBooks) && $latestBooks->count() > 0)
                <div class="book-grid compact">
                    @foreach ($latestBooks as $book)
                        <a href="{{ route('books.show', $book->id) }}" class="book-link">
                            @include('books.cover', ['book' => $book])
                            <h3 class="book-title">{{ $book->judul }}</h3>
                            <div class="book-author">{{ $book->penulis }}</div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <p>Belum ada buku</p>
                    <a href="{{ route('books.create') }}" class="btn">Tambah buku</a>
                </div>
            @endif
        </section>

        {{-- Kategori --}}
        <aside>
            <div class="box">
                <div class="box-head">Jelajahi kategori</div>
                @if (isset($categories) && $categories->count() > 0)
                    @foreach ($categories as $category)
                        <a href="{{ route('books.index', ['category' => $category->id]) }}" class="list-row">
                            {{ $category->nama_kategori }}
                            <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    @endforeach
                @else
                    <div class="box-body" style="color: var(--muted);">Belum ada kategori.</div>
                @endif
            </div>
        </aside>
    </div>
@endsection