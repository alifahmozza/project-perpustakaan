@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('members.index') }}">Anggota</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Tambah anggota</span>
@endsection

@section('hero')
    <h1>Tambah anggota</h1>
    <div class="meta"><span>Lengkapi data untuk mendaftarkan anggota baru.</span></div>
@endsection

@section('content')
    <form action="{{ route('members.store') }}" method="POST" class="form-narrow">
        @csrf

        <div class="row2">
            <div class="field">
                <label for="nama">Nama lengkap</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" autofocus>
                @error('nama') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div class="field">
                <label for="nim">NIM</label>
                <input type="text" name="nim" id="nim" value="{{ old('nim') }}" placeholder="Contoh: 3120500001">
                @error('nim') <div class="err">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row2">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="budi@pens.ac.id">
                @error('email') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div class="field">
                <label for="nomor_telepon">Nomor telepon</label>
                <input type="text" name="nomor_telepon" id="nomor_telepon" maxlength="12" value="{{ old('nomor_telepon') }}" placeholder="081234567890">
                @error('nomor_telepon') <div class="err">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="field">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" rows="3" placeholder="Alamat domisili anggota">{{ old('alamat') }}</textarea>
            @error('alamat') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="status">Status keanggotaan</label>
            <select name="status" id="status">
                <option value="aktif" @selected(old('status', 'aktif') == 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(old('status') == 'nonaktif')>Nonaktif</option>
            </select>
            @error('status') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Simpan anggota</button>
            <a href="{{ route('members.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection