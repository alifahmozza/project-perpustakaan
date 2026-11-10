@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('breadcrumb')
    <a href="{{ url('/dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('books.index') }}">Buku</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Tambah buku</span>
@endsection

@section('hero')
    <h1>Tambah buku</h1>
    <div class="meta"><span>Isi detail buku dan unggah sampulnya.</span></div>
@endsection

@section('content')
    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-layout">
            {{-- Sampul --}}
            <div class="upload">
                <div class="cover" id="coverPreview">
                    <div class="cover-fallback empty">Belum ada sampul</div>
                </div>
                <label for="sampul" class="btn btn-secondary btn-sm">Pilih gambar</label>
                <input type="file" name="sampul" id="sampul" accept="image/*" hidden>
                <p class="hint">JPG, PNG, atau WEBP. Maksimal 2 MB.</p>
                @error('sampul') <div class="err">{{ $message }}</div> @enderror
            </div>

            {{-- Detail --}}
            <div>
                <div class="field">
                    <label for="judul">Judul</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}">
                    @error('judul') <div class="err">{{ $message }}</div> @enderror
                </div>

                <div class="row2">
                    <div class="field">
                        <label for="penulis">Penulis</label>
                        <input type="text" name="penulis" id="penulis" value="{{ old('penulis') }}">
                        @error('penulis') <div class="err">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label for="penerbit">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit') }}">
                        @error('penerbit') <div class="err">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row2">
                    <div class="field">
                        <label for="tahun_terbit">Tahun terbit</label>
                        <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit') }}">
                        @error('tahun_terbit') <div class="err">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label for="stok">Stok</label>
                        <input type="number" name="stok" id="stok" value="{{ old('stok', 1) }}">
                        @error('stok') <div class="err">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row2">
                    <div class="field">
                        <label for="isbn">ISBN (opsional)</label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}">
                        @error('isbn') <div class="err">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label for="category_id">Kategori</label>
                        <select name="category_id" id="category_id">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="err">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Simpan buku</button>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.getElementById('sampul').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const img = document.createElement('img');
            img.alt = 'Pratinjau sampul';
            img.src = URL.createObjectURL(file);
            document.getElementById('coverPreview').replaceChildren(img);
        });
    </script>
@endpush