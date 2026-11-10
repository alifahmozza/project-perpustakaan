@extends('layouts.app')

@section('title', 'Edit Anggota — ' . $member->nama)

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('members.index') }}">Anggota</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('members.show', $member->id) }}">{{ $member->nama }}</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Edit</span>
@endsection

@section('hero')
    <h1>Edit anggota</h1>
    <div class="meta"><span>{{ $member->nama }}</span></div>
@endsection

@section('content')
    <form action="{{ route('members.update', $member->id) }}" method="POST" class="form-narrow">
        @csrf
        @method('PUT')

        <div class="row2">
            <div class="field">
                <label for="nama">Nama lengkap</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $member->nama) }}">
                @error('nama') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div class="field">
                <label for="nim">NIM</label>
                <input type="text" name="nim" id="nim" value="{{ old('nim', $member->nim) }}">
                @error('nim') <div class="err">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row2">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $member->email) }}">
                @error('email') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div class="field">
                <label for="nomor_telepon">Nomor telepon</label>
                <input type="text" name="nomor_telepon" id="nomor_telepon" maxlength="12" value="{{ old('nomor_telepon', $member->nomor_telepon) }}">
                @error('nomor_telepon') <div class="err">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="field">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" rows="3">{{ old('alamat', $member->alamat) }}</textarea>
            @error('alamat') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="status">Status keanggotaan</label>
            <select name="status" id="status">
                <option value="aktif" @selected(old('status', $member->status) == 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(old('status', $member->status) == 'nonaktif')>Nonaktif</option>
            </select>
            @error('status') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Simpan perubahan</button>
            <a href="{{ route('members.show', $member->id) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection