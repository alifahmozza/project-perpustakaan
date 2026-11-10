@extends('layouts.app')

@section('title', 'Detail Buku — ' . $book->judul)

@section('breadcrumb')
    <a href="{{ url('/dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('books.index') }}">Buku</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>{{ Str::limit($book->judul, 40) }}</span>
@endsection

@section('hero')
    <div class="hero-top">
        <div>
            <div class="hero-sub">
                <span class="avatar">{{ Str::upper(Str::substr($book->penulis, 0, 1)) }}</span>
                {{ $book->penulis }}
            </div>
            <h1>{{ $book->judul }}</h1>
            <div class="meta">
                <span>
                    <svg class="i" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    {{ $book->penerbit }}
                </span>
                <span>
                    <svg class="i" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    {{ $book->tahun_terbit }}
                </span>
                <span>
                    <svg class="i" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ $book->stok > 0 ? $book->stok . ' eksemplar tersedia' : 'Stok habis' }}
                </span>
            </div>
        </div>

        <div class="hero-actions">
            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-dark">
                <svg class="i" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Edit
            </a>
        </div>
    </div>

    @if ($book->category)
        <div class="tags">
            <a href="{{ route('books.index', ['category' => $book->category->id]) }}" class="tag">{{ $book->category->nama_kategori }}</a>
        </div>
    @endif
@endsection

@section('content')
    <div class="form-layout">
        {{-- Sampul + aksi utama --}}
        <div>
            @include('books.cover', ['book' => $book])

            <div style="margin-top: 16px; display: grid; gap: 10px;">
                @if ($book->stok > 0)
                    <a href="{{ route('loans.create', ['book_id' => $book->id]) }}" class="btn btn-block">Pinjam buku ini</a>
                @else
                    <span class="btn btn-block btn-disabled">Tidak tersedia</span>
                @endif
            </div>
        </div>

        {{-- Detail --}}
        <div>
            <div class="box">
                <div class="box-head">Detail buku</div>
                <dl>
                    <div class="kv"><dt>Judul</dt><dd>{{ $book->judul }}</dd></div>
                    <div class="kv"><dt>Penulis</dt><dd>{{ $book->penulis }}</dd></div>
                    <div class="kv"><dt>Penerbit</dt><dd>{{ $book->penerbit }}</dd></div>
                    <div class="kv"><dt>Tahun terbit</dt><dd>{{ $book->tahun_terbit }}</dd></div>
                    <div class="kv"><dt>ISBN</dt><dd>{{ $book->isbn ?? '-' }}</dd></div>
                    <div class="kv">
                        <dt>Kategori</dt>
                        <dd><span class="pill">{{ $book->category->nama_kategori ?? '-' }}</span></dd>
                    </div>
                    <div class="kv">
                        <dt>Stok</dt>
                        <dd>
                            <span class="badge {{ $book->stok > 0 ? 'badge-ok' : 'badge-bad' }}">
                                {{ $book->stok }} eksemplar
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <form class="inline" action="{{ route('books.destroy', $book->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus buku ini?')" style="display: block; margin-top: 16px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <svg class="i" viewBox="0 0 24 24" style="width:16px;height:16px"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Hapus buku
                </button>
            </form>
        </div>
    </div>
@endsection