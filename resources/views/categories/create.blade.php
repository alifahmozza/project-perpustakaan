@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('categories.index') }}">Kategori</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Tambah kategori</span>
@endsection

@section('hero')
    <h1>Tambah kategori</h1>
    <div class="meta"><span>Kategori membantu anggota menemukan buku lebih cepat.</span></div>
@endsection

@section('content')
    <form action="{{ route('categories.store') }}" method="POST" class="form-narrow">
        @csrf

        <div class="field">
            <label for="nama_kategori">Nama kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Contoh: Sains & Teknologi" autofocus>
            @error('nama_kategori') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="deskripsi">Deskripsi (opsional)</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Deskripsi singkat kategori ini">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Simpan kategori</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection