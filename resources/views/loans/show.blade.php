@extends('layouts.app')

@section('title', 'Detail Peminjaman #' . $loan->id)

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('loans.index') }}">Peminjaman</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>#{{ $loan->id }}</span>
@endsection

@section('hero')
    <div class="hero-top">
        <div>
            @if ($loan->member)
                <div class="hero-sub">
                    <span class="avatar">{{ Str::upper(Str::substr($loan->member->nama, 0, 1)) }}</span>
                    {{ $loan->member->nama }}
                </div>
            @endif
            <h1>Peminjaman #{{ $loan->id }}</h1>
            <div class="meta">
                <span>
                    <svg class="i" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    {{ $loan->tanggal_pinjam }} sampai {{ $loan->tanggal_kembali }}
                </span>
                <span>
                    <svg class="i" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    {{ $loan->loanItems->count() }} buku
                </span>
            </div>
        </div>

        <div class="hero-actions">
            <span class="status-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span>
            <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-dark">Edit</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="cols">
        {{-- Detail --}}
        <div class="box">
            <div class="box-head">Detail peminjaman</div>
            <dl>
                <div class="kv">
                    <dt>Peminjam</dt>
                    <dd>
                        @if ($loan->member)
                            <a href="{{ route('members.show', $loan->member->id) }}" class="text-link">{{ $loan->member->nama }}</a>
                            <span class="muted">· NIM {{ $loan->member->nim }}</span>
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div class="kv"><dt>Petugas</dt><dd>{{ $loan->user->name ?? '-' }}</dd></div>
                <div class="kv"><dt>Tanggal pinjam</dt><dd>{{ $loan->tanggal_pinjam }}</dd></div>
                <div class="kv">
                    <dt>Batas kembali</dt>
                    <dd @if($loan->status === 'terlambat') style="color: var(--bad); font-weight: 600;" @endif>{{ $loan->tanggal_kembali }}</dd>
                </div>
                <div class="kv">
                    <dt>Tanggal selesai</dt>
                    <dd>
                        @if ($loan->tanggal_dikembalikan)
                            <span style="color: var(--ok); font-weight: 600;">{{ $loan->tanggal_dikembalikan }}</span>
                        @else
                            <span class="muted">Belum dikembalikan</span>
                        @endif
                    </dd>
                </div>
                @if ($loan->denda > 0)
                    <div class="kv">
                        <dt>Denda</dt>
                        <dd>
                            <span class="badge badge-bad">Rp {{ number_format($loan->denda, 0, ',', '.') }}</span>
                            <span class="muted small">Rp 2.000 per hari terlambat</span>
                        </dd>
                    </div>
                @endif
            </dl>
        </div>

        {{-- Buku --}}
        <div class="box">
            <div class="box-head">Buku yang dipinjam</div>
            <div class="box-body">
                @foreach ($loan->loanItems as $item)
                    <div class="book-line">
                        <div class="thumb" style="width: 52px;">
                            @if ($item->book) @include('books.cover', ['book' => $item->book]) @else <div class="cover"></div> @endif
                        </div>
                        <div>
                            @if ($item->book)
                                <a href="{{ route('books.show', $item->book->id) }}" class="text-link">{{ $item->book->judul }}</a>
                            @else
                                Buku (terhapus)
                            @endif
                            <div class="muted small">{{ $item->book->penulis ?? '-' }} · {{ $item->book->category->nama_kategori ?? '-' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 24px;">
        @if ($loan->status === 'dipinjam' || $loan->status === 'terlambat')
            <form class="inline" action="{{ route('loans.kembalikan', $loan->id) }}" method="POST"
                  onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                @csrf
                @method('PUT')
                <button type="submit" class="btn">Kembalikan buku</button>
            </form>
        @endif
        <a href="{{ route('loans.index') }}" class="btn btn-secondary">Daftar peminjaman</a>
    </div>
@endsection