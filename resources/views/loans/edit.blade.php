@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('loans.index') }}">Peminjaman</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Edit #{{ $loan->id }}</span>
@endsection

@section('hero')
    <h1>Edit peminjaman #{{ $loan->id }}</h1>
    <div class="meta"><span>Anggota dan buku tidak bisa diubah, hanya jadwal dan status.</span></div>
@endsection

@section('content')
    <div class="form-narrow">
        <div class="field">
            <label>Anggota</label>
            <div class="readonly">{{ $loan->member->nama }} ({{ $loan->member->nim }})</div>
        </div>

        <div class="field">
            <label>Buku</label>
            <div>
                @foreach ($loan->loanItems as $item)
                    <div class="book-line">
                        <div class="thumb">
                            @if ($item->book) @include('books.cover', ['book' => $item->book]) @else <div class="cover"></div> @endif
                        </div>
                        <span>{{ $item->book->judul ?? 'Buku (terhapus)' }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <form action="{{ route('loans.update', $loan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="tanggal_pinjam" value="{{ $loan->tanggal_pinjam }}">

            <div class="row2">
                <div class="field">
                    <label for="tanggal_kembali">Tanggal kembali</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali', $loan->tanggal_kembali) }}">
                    @error('tanggal_kembali') <div class="err">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="dipinjam" @selected(old('status', $loan->status) == 'dipinjam')>Dipinjam</option>
                        <option value="dikembalikan" @selected(old('status', $loan->status) == 'dikembalikan')>Dikembalikan</option>
                        <option value="terlambat" @selected(old('status', $loan->status) == 'terlambat')>Terlambat</option>
                    </select>
                    @error('status') <div class="err">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan perubahan</button>
                <a href="{{ route('loans.show', $loan->id) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection