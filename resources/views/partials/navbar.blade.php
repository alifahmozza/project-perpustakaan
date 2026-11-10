{{-- Top Bar --}}
<div class="topbar">
    <div class="brand-top">
        <span>📚</span>
        <span>Perpustakaan Digital Kampus</span>
    </div>
    <div class="topbar-right">
        @auth
            <a href="{{ route('profil.show') }}" title="Lihat Profil Petugas" style="display: inline-flex; align-items: center; gap: 6px;">
                <span>👤</span>
                <span>{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
            </a>
        @endauth
    </div>
</div>

{{-- Main Navigation --}}
<nav class="main-nav">
    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo-icon">OPEN</span>
        <span class="logo-text">LIBRARY</span>
    </a>

    @auth
        <ul class="nav-links">
            <li><a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">📖 Buku</a></li>
            @if (auth()->user()->role === 'admin')
                <li><a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">📂 Kategori</a></li>
            @endif
            <li><a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">👥 Anggota</a></li>
            <li><a href="{{ route('loans.index') }}" class="{{ request()->routeIs('loans.index') || request()->routeIs('loans.create') || request()->routeIs('loans.show') || request()->routeIs('loans.edit') ? 'active' : '' }}">📋 Peminjaman</a></li>
            <li><a href="{{ route('loans.report') }}" class="{{ request()->routeIs('loans.report') ? 'active' : '' }}">📊 Laporan</a></li>
        </ul>
    @endauth

    <div class="search-box">
        <form action="{{ route('books.index') }}" method="GET" style="display:flex; width:100%;">
            <input type="text" name="search" placeholder="Cari buku, penulis, ISBN..." value="{{ request('search') }}">
            <button type="submit">🔍</button>
        </form>
    </div>

    <div class="nav-auth">
        @auth
            <a href="{{ route('profil.show') }}" class="btn btn-secondary" style="padding: 5px 12px; font-size: 13px;">Profil</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-logout-nav">Logout</button>
            </form>
        @endauth
        @guest
            <a href="{{ route('login') }}">Log In</a>
        @endguest
    </div>
</nav>
