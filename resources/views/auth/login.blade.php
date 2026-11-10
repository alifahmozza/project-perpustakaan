<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Perpustakaan Digital Kampus</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">

    <style>
        :root {
            --plum: #4a2840; --accent: #ef4f2c; --accent-dark: #d63f1d;
            --ink: #1d2130; --muted: #6a7080; --line: #e7e8ee; --bg: #f6f7f9;
            --ok: #17794a; --ok-soft: #e4f5ec; --bad: #c0352b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg); color: var(--ink); font-size: 14px; line-height: 1.5;
            min-height: 100vh; -webkit-font-smoothing: antialiased;
        }
        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

        .band { background: var(--plum); height: 300px; padding: 40px 24px 0; text-align: center; }
        .brand { display: inline-flex; align-items: center; gap: 10px; color: #fff; font-size: 22px; font-weight: 700; letter-spacing: -.01em; text-decoration: none; }
        .brand-mark { width: 32px; height: 32px; border-radius: 8px; background: var(--accent); display: grid; place-items: center; }
        .brand-mark svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        .card {
            position: relative; z-index: 1;
            width: calc(100% - 32px); max-width: 400px; margin: -170px auto 0;
            background: #fff; border-radius: 16px; padding: 32px;
            box-shadow: 0 1px 2px rgba(20, 16, 30, .04), 0 8px 28px rgba(20, 16, 30, .08);
        }
        .card h1 { font-size: 22px; font-weight: 600; letter-spacing: -.01em; }
        .card .sub { color: var(--muted); margin: 4px 0 22px; }

        .alert-success { background: var(--ok-soft); color: var(--ok); padding: 12px 16px; border-radius: 10px; margin-bottom: 18px; }
        .field { margin-bottom: 16px; }
        .field label { display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; }
        .field input[type="email"], .field input[type="password"] {
            width: 100%; height: 44px; padding: 0 14px; border: 1px solid #d9dce4; border-radius: 10px;
            font: inherit; color: var(--ink); transition: border-color .15s, box-shadow .15s;
        }
        .field input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(239, 79, 44, .15); }
        .error { color: var(--bad); font-size: 13px; margin-top: 6px; }

        .remember { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; color: var(--muted); }
        .remember input { width: 16px; height: 16px; accent-color: var(--accent); }

        .btn-login {
            width: 100%; height: 44px; border: 0; border-radius: 10px; background: var(--accent); color: #fff;
            font: inherit; font-weight: 600; cursor: pointer; transition: background .15s;
        }
        .btn-login:hover { background: var(--accent-dark); }

        .footer-text { text-align: center; margin: 24px 0; font-size: 13px; color: var(--muted); }
    </style>
</head>
<body>
    <div class="band">
        <a href="/" class="brand">
            <span class="brand-mark">
                <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </span>
            Perpustakaan
        </a>
    </div>

    <main class="card">
        <h1>Masuk ke akun</h1>
        <p class="sub">Gunakan email kampus kamu untuk meminjam dan mengelola buku.</p>

        @if (session('success'))
            <div class="alert-success" role="status">{{ session('success') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" autocomplete="current-password">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <label class="remember">
                <input type="checkbox" name="remember" id="remember">
                Ingat saya
            </label>

            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </main>

    <p class="footer-text">&copy; {{ date('Y') }} Perpustakaan Digital Kampus</p>
</body>
</html>