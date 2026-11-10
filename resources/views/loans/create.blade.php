@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('loans.index') }}">Peminjaman</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Tambah peminjaman</span>
@endsection

@section('hero')
    <h1>Tambah peminjaman</h1>
    <div class="meta">
        <span>
            <svg class="i" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Petugas pencatat: {{ auth()->user()->name }}
        </span>
    </div>
@endsection

@section('content')
    <form action="{{ route('loans.store') }}" method="POST" class="form-narrow">
        @csrf

        <div class="field">
            <label for="member_id">Anggota</label>
            <select name="member_id" id="member_id">
                <option value="">Pilih anggota</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" @selected(old('member_id', request('member_id')) == $member->id)>
                        {{ $member->nama }} ({{ $member->nim }})
                    </option>
                @endforeach
            </select>
            @error('member_id') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="row2">
            <div class="field">
                <label for="tanggal_pinjam">Tanggal pinjam</label>
                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}">
                @error('tanggal_pinjam') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div class="field">
                <label for="tanggal_kembali">Tanggal kembali</label>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali') }}">
                @error('tanggal_kembali') <div class="err">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="field">
            <label>Buku yang dipinjam</label>
            <div class="picker">
                @php $selected = array_map('intval', (array) old('book_ids', request('book_id') ? [request('book_id')] : [])); @endphp
                @forelse ($books as $book)
                    <label class="pick">
                        <input type="checkbox" name="book_ids[]" value="{{ $book->id }}" @checked(in_array($book->id, $selected))>
                        <div class="thumb">@include('books.cover', ['book' => $book])</div>
                        <div>
                            <div style="font-weight: 600;">{{ $book->judul }}</div>
                            <div class="muted small">{{ $book->penulis }} · Stok {{ $book->stok }}</div>
                        </div>
                    </label>
                @empty
                    <p class="muted" style="padding: 12px;">Belum ada data buku.</p>
                @endforelse
            </div>
            @error('book_ids') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Simpan peminjaman</button>
            <a href="{{ route('loans.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection