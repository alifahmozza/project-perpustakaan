@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('loans.index') }}">Peminjaman</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Laporan</span>
@endsection

@section('hero')
    <div class="hero-top">
        <div>
            <h1>Laporan peminjaman</h1>
            <div class="meta"><span>Status sirkulasi buku, peminjaman aktif, dan denda keterlambatan.</span></div>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-dark">Kembali ke beranda</a>
    </div>
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="value">{{ $totalLoans }}</div>
            <div class="label">Total transaksi</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color: #9a5b00;">{{ $totalDipinjam }}</div>
            <div class="label">Sedang dipinjam</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color: var(--ok);">{{ $totalDikembalikan }}</div>
            <div class="label">Dikembalikan</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color: var(--bad);">{{ $totalTerlambat }}</div>
            <div class="label">Terlambat</div>
        </div>
        <div class="stat-card">
            <div class="value" style="color: var(--bad);">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
            <div class="label">Total denda</div>
        </div>
    </div>

    @if ($loans->count() > 0)
        <div class="table-wrap">
            <table style="min-width: 900px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Anggota</th>
                        <th>Petugas</th>
                        <th>Buku</th>
                        <th>Pinjam</th>
                        <th>Batas kembali</th>
                        <th>Selesai</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        <tr>
                            <td><strong>#{{ $loan->id }}</strong></td>
                            <td>
                                @if ($loan->member)
                                    <a href="{{ route('members.show', $loan->member->id) }}" class="text-link">{{ $loan->member->nama }}</a>
                                    <div class="muted small">NIM {{ $loan->member->nim }}</div>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $loan->user->name ?? '-' }}</td>
                            <td>
                                @foreach ($loan->loanItems as $item)
                                    <div class="book-line">
                                        <div class="thumb">
                                            @if ($item->book) @include('books.cover', ['book' => $item->book]) @else <div class="cover"></div> @endif
                                        </div>
                                        <span>{{ $item->book->judul ?? 'Buku' }}</span>
                                    </div>
                                @endforeach
                            </td>
                            <td style="white-space: nowrap;">{{ $loan->tanggal_pinjam }}</td>
                            <td style="white-space: nowrap;">{{ $loan->tanggal_kembali }}</td>
                            <td style="white-space: nowrap;">
                                @if ($loan->tanggal_dikembalikan)
                                    <span style="color: var(--ok); font-weight: 500;">{{ $loan->tanggal_dikembalikan }}</span>
                                @else
                                    <span class="muted">Belum kembali</span>
                                @endif
                            </td>
                            <td><span class="status-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span></td>
                            <td style="white-space: nowrap;">
                                @if ($loan->denda > 0)
                                    <span class="badge badge-bad">Rp {{ number_format($loan->denda, 0, ',', '.') }}</span>
                                @else
                                    <span class="muted">Rp 0</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $loans->links() }}
    @else
        <div class="empty-state">
            <p>Belum ada data peminjaman untuk dilaporkan</p>
        </div>
    @endif
@endsection