<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Digital Kampus')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">

    <style>
        :root {
            --plum: #4a2840;
            --plum-line: rgba(255, 255, 255, .12);
            --accent: #ef4f2c;
            --accent-dark: #d63f1d;
            --accent-soft: #fdeeea;
            --ink: #1d2130;
            --muted: #6a7080;
            --line: #e7e8ee;
            --bg: #f6f7f9;
            --ok: #17794a;
            --ok-soft: #e4f5ec;
            --bad: #c0352b;
            --bad-soft: #fdeceb;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { -webkit-text-size-adjust: 100%; }
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg); color: var(--ink);
            font-size: 14px; line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }
        button { font: inherit; }
        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
        svg.i {
            width: 18px; height: 18px; flex-shrink: 0; fill: none; stroke: currentColor;
            stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;
        }

        .container { width: 100%; max-width: 1180px; margin: 0 auto; padding: 0 24px; }

        /* ---------- Header band ---------- */
        .band { background: var(--plum); padding-bottom: 88px; color: #fff; }
        .topbar { border-bottom: 1px solid var(--plum-line); }
        .topbar-in { display: flex; align-items: stretch; gap: 32px; min-height: 64px; }
        .brand { display: flex; align-items: center; gap: 10px; font-size: 20px; font-weight: 700; letter-spacing: -.01em; }
        .brand-mark {
            width: 30px; height: 30px; border-radius: 8px; background: var(--accent);
            display: grid; place-items: center;
        }
        .brand-mark svg { width: 17px; height: 17px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .nav { flex: 1; display: flex; justify-content: center; gap: 22px; white-space: nowrap; }
        .nav a {
            display: flex; align-items: center; padding: 0 2px;
            color: rgba(255, 255, 255, .62); font-size: 14px; font-weight: 500;
            border-bottom: 2px solid transparent; transition: color .15s;
        }
        .nav a:hover { color: #fff; }
        .nav a.active { color: #fff; border-bottom-color: var(--accent); }
        .user { display: flex; align-items: center; gap: 12px; }
        .avatar {
            width: 36px; height: 36px; border-radius: 50%; background: rgba(255, 255, 255, .16);
            display: grid; place-items: center; font-weight: 600; font-size: 14px;
        }
        .link-btn {
            background: none; border: 0; color: rgba(255, 255, 255, .7); cursor: pointer; font-size: 13px; font-weight: 500;
        }
        .link-btn:hover { color: #fff; }

        .search { position: relative; align-self: center; width: 210px; }
        .search svg.i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: rgba(255, 255, 255, .55); }
        .search input {
            width: 100%; height: 36px; padding: 0 12px 0 34px; border-radius: 10px; font: inherit; font-size: 13px; color: #fff;
            background: rgba(255, 255, 255, .1); border: 1px solid rgba(255, 255, 255, .14);
        }
        .search input::placeholder { color: rgba(255, 255, 255, .55); }
        .search input:focus { outline: none; background: rgba(255, 255, 255, .16); border-color: rgba(255, 255, 255, .4); }
        .user { align-self: center; }
        .user-link { display: flex; align-items: center; gap: 10px; }
        .user-name { display: flex; flex-direction: column; line-height: 1.2; font-size: 13px; font-weight: 500; }
        .user-name small { font-size: 11px; color: rgba(255, 255, 255, .6); font-weight: 400; }
        .avatar-sm {
            width: 32px; height: 32px; border-radius: 50%; background: var(--accent-soft); color: var(--accent-dark);
            display: grid; place-items: center; font-weight: 600; font-size: 13px; flex-shrink: 0;
        }
        .toolbar { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }
        .toolbar input {
            flex: 1; min-width: 200px; height: 40px; padding: 0 14px; border: 1px solid #d9dce4; border-radius: 10px;
            font: inherit; transition: border-color .15s, box-shadow .15s;
        }
        .toolbar input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(239, 79, 44, .15); }
        .mono { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 12px; }
        @media (max-width: 1100px) { .user-name { display: none; } .search { width: 170px; } }

        .crumbs { border-bottom: 1px solid var(--plum-line); }
        .crumbs .container { display: flex; align-items: center; gap: 10px; min-height: 48px; color: rgba(255, 255, 255, .6); font-size: 14px; }
        .crumbs a { color: rgba(255, 255, 255, .92); }
        .crumbs a:hover { text-decoration: underline; }
        .crumbs svg.i { width: 14px; height: 14px; }

        .hero { padding-top: 36px; }
        .hero-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; flex-wrap: wrap; }
        .hero h1 { font-size: 28px; font-weight: 600; letter-spacing: -.01em; line-height: 1.25; }
        .hero-sub { display: flex; align-items: center; gap: 10px; font-size: 15px; margin-bottom: 10px; color: rgba(255, 255, 255, .92); }
        .hero-sub .avatar { width: 24px; height: 24px; font-size: 11px; }
        .meta { display: flex; flex-wrap: wrap; gap: 8px 22px; margin-top: 12px; color: rgba(255, 255, 255, .75); font-size: 15px; }
        .meta span { display: inline-flex; align-items: center; gap: 8px; }
        .tags { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 24px; }
        .tag {
            padding: 6px 14px; border-radius: 8px; font-size: 14px; color: rgba(255, 255, 255, .8);
            background: rgba(255, 255, 255, .08); border: 1px solid rgba(255, 255, 255, .1);
            transition: background .15s;
        }
        a.tag:hover { background: rgba(255, 255, 255, .16); color: #fff; }
        .hero-status { display: inline-flex; align-items: center; gap: 8px; font-size: 15px; color: rgba(255, 255, 255, .9); }
        .hero-actions { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }

        /* ---------- Main panel ---------- */
        .main { margin-top: -56px; padding-bottom: 64px; position: relative; }
        .panel {
            background: #fff; border-radius: 16px; padding: 28px;
            box-shadow: 0 1px 2px rgba(20, 16, 30, .04), 0 8px 28px rgba(20, 16, 30, .06);
        }

        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: var(--ok-soft); color: var(--ok); }
        .alert-error { background: var(--bad-soft); color: var(--bad); }

        /* ---------- Buttons ---------- */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            height: 40px; padding: 0 18px; border-radius: 10px; border: 1px solid transparent;
            background: var(--accent); color: #fff; font-weight: 600; font-size: 14px;
            cursor: pointer; transition: background .15s, border-color .15s;
        }
        .btn:hover { background: var(--accent-dark); }
        .btn-secondary { background: #fff; color: var(--ink); border-color: var(--line); }
        .btn-secondary:hover { background: #f3f4f7; }
        .btn-danger { background: #fff; color: var(--bad); border-color: #f3cfcc; }
        .btn-danger:hover { background: var(--bad-soft); }
        .btn-dark { background: rgba(255, 255, 255, .1); border-color: rgba(255, 255, 255, .2); color: #fff; }
        .btn-dark:hover { background: rgba(255, 255, 255, .18); }
        .btn-sm { height: 34px; padding: 0 14px; font-size: 13px; }
        .btn-block { width: 100%; }
        .btn-disabled, .btn-disabled:hover { background: #eceef2; color: #9aa0ae; cursor: not-allowed; }
        .icon-btn {
            width: 34px; height: 34px; border-radius: 10px; border: 1px solid var(--line); background: #fff;
            display: grid; place-items: center; color: var(--muted); cursor: pointer;
            transition: background .15s, color .15s;
        }
        .icon-btn:hover { background: #f3f4f7; color: var(--ink); }
        .icon-btn.danger:hover { background: var(--bad-soft); color: var(--bad); border-color: #f3cfcc; }
        form.inline { display: inline; }

        /* ---------- Boxes ---------- */
        .box { border: 1px solid var(--line); border-radius: 12px; overflow: hidden; background: #fff; }
        .box-head { padding: 14px 20px; background: #fafbfc; border-bottom: 1px solid var(--line); font-weight: 600; font-size: 15px; display: flex; justify-content: space-between; align-items: center; }
        .box-body { padding: 20px; }
        .section-title { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 18px; }
        .section-title h2 { font-size: 17px; font-weight: 600; letter-spacing: -.005em; }
        .section-title a { font-size: 13px; font-weight: 600; color: var(--accent-dark); }
        .section-title a:hover { text-decoration: underline; }
        .cols { display: grid; grid-template-columns: minmax(0, 1.9fr) minmax(0, 1fr); gap: 28px; align-items: start; }

        .list-row {
            display: flex; justify-content: space-between; align-items: center; gap: 12px;
            padding: 14px 20px; border-bottom: 1px solid var(--line); font-weight: 500; transition: background .15s;
        }
        .list-row:last-child { border-bottom: 0; }
        .list-row:hover { background: #fafbfc; }
        .list-row svg.i { color: var(--muted); width: 16px; height: 16px; }

        .kv { display: grid; grid-template-columns: 150px 1fr; gap: 12px; padding: 14px 20px; border-bottom: 1px solid var(--line); }
        .kv:last-child { border-bottom: 0; }
        .kv dt { color: var(--muted); }
        .kv dd { font-weight: 500; }

        .pill { display: inline-block; background: #f1f2f6; color: #4b5163; padding: 2px 9px; border-radius: 6px; font-size: 12px; font-weight: 500; }
        .badge { display: inline-block; padding: 2px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .badge-ok { background: var(--ok-soft); color: var(--ok); }
        .badge-bad { background: var(--bad-soft); color: var(--bad); }

        /* ---------- Book cover ---------- */
        .cover { aspect-ratio: 2 / 3; border-radius: 10px; overflow: hidden; background: #ece9ee; box-shadow: 0 1px 3px rgba(20, 16, 30, .18); }
        .cover img { width: 100%; height: 100%; object-fit: cover; }
        .cover-fallback {
            height: 100%; display: flex; flex-direction: column; justify-content: space-between;
            padding: 16px 14px 14px 20px; color: #fff; position: relative;
            background: linear-gradient(160deg, hsl(var(--h) 30% 40%), hsl(var(--h) 34% 24%));
        }
        .cover-fallback::before { content: ''; position: absolute; top: 0; bottom: 0; left: 9px; width: 2px; background: rgba(255, 255, 255, .18); }
        .cover-fallback .t {
            font-weight: 600; font-size: 14px; line-height: 1.3; word-break: break-word;
            display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical; overflow: hidden;
        }
        .cover-fallback .a { font-size: 11px; opacity: .75; }
        .cover-fallback.empty { background: #ece9ee; color: var(--muted); align-items: center; justify-content: center; text-align: center; padding: 16px; font-size: 13px; }
        .cover-fallback.empty::before { display: none; }

        .book-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(168px, 1fr)); gap: 28px 20px; }
        .book-grid.compact { grid-template-columns: repeat(auto-fill, minmax(132px, 1fr)); gap: 24px 16px; }
        .book-title {
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
            margin-top: 12px; font-weight: 600; font-size: 14px; line-height: 1.35;
        }
        a.book-link:hover .book-title { color: var(--accent-dark); }
        .book-author { color: var(--muted); font-size: 13px; margin-top: 2px; }
        .book-foot { display: flex; justify-content: space-between; align-items: center; gap: 8px; margin-top: 10px; }
        .stock { font-size: 12px; font-weight: 600; }
        .stock.ok { color: var(--ok); }
        .stock.bad { color: var(--bad); }
        .book-actions { display: flex; align-items: center; gap: 8px; margin-top: 12px; }
        .book-actions .btn { flex: 1; }

        .empty-state { text-align: center; padding: 56px 20px; color: var(--muted); }
        .empty-state p { font-size: 16px; color: var(--ink); font-weight: 500; margin-bottom: 4px; }
        .empty-state .btn { margin-top: 18px; }

        /* ---------- Forms ---------- */
        .form-layout { display: grid; grid-template-columns: 240px minmax(0, 1fr); gap: 36px; align-items: start; }
        .field { margin-bottom: 18px; }
        .field label { display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; }
        .field input, .field select {
            width: 100%; height: 44px; padding: 0 14px; border: 1px solid #d9dce4; border-radius: 10px;
            background: #fff; color: var(--ink); font: inherit; transition: border-color .15s, box-shadow .15s;
        }
        .field input:focus, .field select:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(239, 79, 44, .15); }
        .err { color: var(--bad); font-size: 13px; margin-top: 6px; }
        .hint { color: var(--muted); font-size: 12px; margin-top: 8px; }
        .row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .upload { text-align: center; }
        .upload .btn { margin-top: 14px; }
        .form-actions { display: flex; gap: 10px; margin-top: 8px; }

        .field textarea {
            width: 100%; padding: 12px 14px; border: 1px solid #d9dce4; border-radius: 10px; background: #fff;
            color: var(--ink); font: inherit; resize: vertical; transition: border-color .15s, box-shadow .15s;
        }
        .field textarea:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(239, 79, 44, .15); }
        .form-narrow { max-width: 680px; }
        .readonly { background: #f6f7f9; border-radius: 10px; padding: 11px 14px; }

        /* ---------- Tables ---------- */
        .table-wrap { overflow-x: auto; border: 1px solid var(--line); border-radius: 12px; }
        table { border-collapse: collapse; width: 100%; min-width: 640px; }
        th {
            background: #fafbfc; color: var(--muted); font-size: 13px; font-weight: 600; text-align: left;
            padding: 12px 16px; border-bottom: 1px solid var(--line); white-space: nowrap;
        }
        td { padding: 14px 16px; border-bottom: 1px solid var(--line); vertical-align: top; }
        tbody tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: #fcfcfd; }
        .text-link { color: var(--accent-dark); font-weight: 600; }
        .text-link:hover { text-decoration: underline; }
        .muted { color: var(--muted); }
        .small { font-size: 12px; }
        .actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

        /* ---------- Status & stats ---------- */
        .status-dipinjam, .status-dikembalikan, .status-terlambat {
            display: inline-block; padding: 2px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; white-space: nowrap;
        }
        .status-dipinjam { background: #fff3dc; color: #9a5b00; }
        .status-dikembalikan { background: var(--ok-soft); color: var(--ok); }
        .status-terlambat { background: var(--bad-soft); color: var(--bad); }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat-card { border: 1px solid var(--line); border-radius: 12px; padding: 18px 20px; }
        .stat-card .value { font-size: 26px; font-weight: 600; letter-spacing: -.01em; line-height: 1.2; }
        .stat-card .label { color: var(--muted); margin-top: 4px; }

        /* ---------- Pagination ---------- */
        .pagination { margin-top: 24px; display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
        .pagination a, .pagination .pagination-current, .pagination .pagination-disabled {
            padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 500;
        }
        .pagination a { border: 1px solid var(--line); color: var(--ink); }
        .pagination a:hover { background: #f3f4f7; }
        .pagination .pagination-current { background: var(--accent); color: #fff; font-weight: 600; }
        .pagination .pagination-disabled { color: #a0a5b3; }

        /* ---------- Mini cover & book picker ---------- */
        .thumb { width: 34px; flex-shrink: 0; }
        .thumb .cover { border-radius: 4px; box-shadow: none; }
        .thumb .cover-fallback { padding: 0; }
        .thumb .cover-fallback::before, .thumb .cover-fallback .t, .thumb .cover-fallback .a { display: none; }
        .book-line { display: flex; align-items: center; gap: 10px; }
        .book-line + .book-line { margin-top: 8px; }
        .picker { border: 1px solid var(--line); border-radius: 12px; max-height: 320px; overflow-y: auto; padding: 6px; }
        .pick {
            display: flex; align-items: center; gap: 12px; padding: 8px 10px; border-radius: 10px;
            border: 1px solid transparent; cursor: pointer; font-weight: 400 !important; margin: 0 !important;
        }
        .pick:hover { background: #f6f7f9; }
        .pick:has(input:checked) { background: var(--accent-soft); border-color: #f6c9bd; }
        .pick input { width: 16px !important; height: 16px !important; accent-color: var(--accent); flex-shrink: 0; padding: 0 !important; }

        footer { text-align: center; padding: 8px 24px 40px; color: var(--muted); font-size: 13px; }

        @media (max-width: 900px) {
            .cols, .form-layout { grid-template-columns: 1fr; }
            .form-layout .upload { max-width: 220px; }
        }
        @media (max-width: 720px) {
            .topbar-in { flex-wrap: wrap; gap: 0 16px; padding-top: 12px; }
            .nav { order: 3; width: 100%; justify-content: flex-start; min-height: 46px; overflow-x: auto; }
            .user { margin-left: auto; }
            .search { order: 2; width: 100%; margin: 8px 0; }
            .panel { padding: 18px; }
            .hero h1 { font-size: 24px; }
            .row2 { grid-template-columns: 1fr; gap: 0; }
            .kv { grid-template-columns: 1fr; gap: 2px; }
        }
        @media (max-width: 480px) {
            .container { padding: 0 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="band">
        <header class="topbar">
            <div class="container topbar-in">
                <a href="{{ route('dashboard') }}" class="brand">
                    <span class="brand-mark">
                        <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </span>
                    Perpustakaan
                </a>

                @auth
                    <nav class="nav" aria-label="Navigasi utama">
                        <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">Buku</a>
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Kategori</a>
                        @endif
                        <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">Anggota</a>
                        <a href="{{ route('loans.index') }}" class="{{ request()->routeIs('loans.*') && !request()->routeIs('loans.report') ? 'active' : '' }}">Peminjaman</a>
                        <a href="{{ route('loans.report') }}" class="{{ request()->routeIs('loans.report') ? 'active' : '' }}">Laporan</a>
                    </nav>
                @else
                    <div class="nav"></div>
                @endauth

                <form action="{{ route('books.index') }}" method="GET" class="search" role="search">
                    <svg class="i" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                    <input type="search" name="search" placeholder="Cari buku, penulis, ISBN" value="{{ request('search') }}" aria-label="Cari buku">
                </form>

                <div class="user">
                    @auth
                        <a href="{{ route('profil.show') }}" class="user-link" title="Lihat profil petugas">
                            <span class="avatar">{{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}</span>
                            <span class="user-name">{{ auth()->user()->name }}<small>{{ ucfirst(auth()->user()->role) }}</small></span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="link-btn">Keluar</button>
                        </form>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="link-btn">Masuk</a>
                    @endguest
                </div>
            </div>
        </header>

        @hasSection('breadcrumb')
            <div class="crumbs">
                <div class="container">@yield('breadcrumb')</div>
            </div>
        @endif

        <div class="container hero">
            @yield('hero')
        </div>
    </div>

    <main class="container main">
        <div class="panel">
            @if (session('success'))
                <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error" role="alert">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer>&copy; {{ date('Y') }} Perpustakaan Digital Kampus</footer>

    @stack('scripts')
</body>
</html>