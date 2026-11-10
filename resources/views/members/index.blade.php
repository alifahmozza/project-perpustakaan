@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Anggota</span>
@endsection

@section('hero')
    <div class="hero-top">
        <div>
            <h1>Anggota perpustakaan</h1>
            <div class="meta">
                <span>
                    <svg class="i" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    {{ $members->total() }} anggota terdaftar
                </span>
            </div>
        </div>
        <a href="{{ route('members.create') }}" class="btn btn-dark">
            <svg class="i" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Tambah anggota
        </a>
    </div>
@endsection

@section('content')
    <form action="{{ route('members.index') }}" method="GET" class="toolbar" role="search">
        <input type="text" name="search" placeholder="Cari nama anggota atau NIM" value="{{ request('search') }}" aria-label="Cari anggota">
        <button type="submit" class="btn">Cari</button>
        @if (request('search'))
            <a href="{{ route('members.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    @if ($members->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Email</th>
                        <th>No. telepon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <td>
                                <div class="book-line">
                                    <span class="avatar-sm">{{ Str::upper(Str::substr($member->nama, 0, 1)) }}</span>
                                    <a href="{{ route('members.show', $member->id) }}" class="text-link">{{ $member->nama }}</a>
                                </div>
                            </td>
                            <td><span class="pill mono">{{ $member->nim }}</span></td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->nomor_telepon }}</td>
                            <td>
                                <span class="badge {{ $member->status === 'aktif' ? 'badge-ok' : 'badge-bad' }}">{{ ucfirst($member->status) }}</span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('members.show', $member->id) }}" class="btn btn-secondary btn-sm">Lihat</a>
                                    <a href="{{ route('members.edit', $member->id) }}" class="icon-btn" title="Edit anggota" aria-label="Edit {{ $member->nama }}">
                                        <svg class="i" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    </a>
                                    <form class="inline" action="{{ route('members.destroy', $member->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus anggota ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn danger" title="Hapus anggota" aria-label="Hapus {{ $member->nama }}">
                                            <svg class="i" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $members->links() }}
    @else
        <div class="empty-state">
            <p>{{ request('search') ? 'Anggota tidak ditemukan' : 'Belum ada anggota' }}</p>
            @if (!request('search'))
                <a href="{{ route('members.create') }}" class="btn">Tambah anggota pertama</a>
            @endif
        </div>
    @endif
@endsection