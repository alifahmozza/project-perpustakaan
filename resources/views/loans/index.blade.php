@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Peminjaman</span>
@endsection

@section('hero')
    <div class="hero-top">
        <div>
            <h1>Transaksi peminjaman</h1>
            <div class="meta"><span>{{ $loans->total() }} transaksi sirkulasi buku</span></div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('loans.report') }}" class="btn btn-dark">Laporan</a>
            <a href="{{ route('loans.create') }}" class="btn btn-dark">
                <svg class="i" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                Tambah peminjaman
            </a>
        </div>
    </div>
@endsection

@section('content')
    @if ($loans->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        <tr>
                            <td>
                                @if ($loan->member)
                                    <a href="{{ route('members.show', $loan->member->id) }}" class="text-link">{{ $loan->member->nama }}</a>
                                    <div class="muted small">{{ $loan->member->nim }}</div>
                                @else
                                    -
                                @endif
                                <div class="muted small" style="margin-top: 4px;">#{{ $loan->id }} · Petugas: {{ $loan->user->name ?? '-' }}</div>
                            </td>
                            <td>
                                @foreach ($loan->loanItems as $item)
                                    <div class="book-line">
                                        <div class="thumb">
                                            @if ($item->book) @include('books.cover', ['book' => $item->book]) @else <div class="cover"></div> @endif
                                        </div>
                                        <span>{{ $item->book->judul ?? 'Buku (terhapus)' }}</span>
                                    </div>
                                @endforeach
                            </td>
                            <td style="white-space: nowrap;">
                                <div>Pinjam: {{ $loan->tanggal_pinjam }}</div>
                                <div class="{{ $loan->status === 'terlambat' ? '' : 'muted' }}" @if($loan->status === 'terlambat') style="color: var(--bad); font-weight: 600;" @endif>
                                    Batas: {{ $loan->tanggal_kembali }}
                                </div>
                                @if ($loan->tanggal_dikembalikan)
                                    <div style="color: var(--ok); font-weight: 500;">Kembali: {{ $loan->tanggal_dikembalikan }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="status-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span>
                                @if ($loan->denda > 0)
                                    <div style="margin-top: 6px;"><span class="badge badge-bad">Denda Rp {{ number_format($loan->denda, 0, ',', '.') }}</span></div>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    @if ($loan->status === 'dipinjam' || $loan->status === 'terlambat')
                                        <form class="inline" action="{{ route('loans.kembalikan', $loan->id) }}" method="POST"
                                              onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm">Kembalikan</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('loans.show', $loan->id) }}" class="btn btn-secondary btn-sm">Detail</a>
                                    <a href="{{ route('loans.edit', $loan->id) }}" class="icon-btn" title="Edit peminjaman" aria-label="Edit peminjaman #{{ $loan->id }}">
                                        <svg class="i" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    </a>
                                    <form class="inline" action="{{ route('loans.destroy', $loan->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus transaksi peminjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn danger" title="Hapus peminjaman" aria-label="Hapus peminjaman #{{ $loan->id }}">
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

        {{ $loans->links() }}
    @else
        <div class="empty-state">
            <p>Belum ada data peminjaman</p>
            <a href="{{ route('loans.create') }}" class="btn">Buat peminjaman pertama</a>
        </div>
    @endif
@endsection