@extends('layouts.app')

@section('title', 'Edit Kategori — ' . $category->nama_kategori)

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('categories.index') }}">Kategori</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Edit {{ $category->nama_kategori }}</span>
@endsection

@section('hero')
    <h1>Edit kategori</h1>
    <div class="meta"><span>{{ $category->nama_kategori }}</span></div>
@endsection

@section('content')
    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="form-narrow">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="nama_kategori">Nama kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori) }}" autofocus>
            @error('nama_kategori') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="deskripsi">Deskripsi (opsional)</label>
            <textarea name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi', $category->deskripsi) }}</textarea>
            @error('deskripsi') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Simpan perubahan</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection