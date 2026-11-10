@extends('layouts.app')

@section('title', 'Profil Petugas')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Profil</span>
@endsection

@section('hero')
    <div class="hero-sub">
        <span class="avatar">{{ Str::upper(Str::substr($user->name, 0, 1)) }}</span>
        {{ ucfirst($user->role ?? 'Petugas') }}
    </div>
    <h1>{{ $user->name }}</h1>
    <div class="meta"><span>{{ $user->email }}</span></div>
@endsection

@section('content')
    <div class="form-narrow">
        <div class="box" style="margin-bottom: 28px;">
            <div class="box-head">Informasi akun</div>
            <dl>
                <div class="kv"><dt>Nama</dt><dd>{{ $user->name }}</dd></div>
                <div class="kv"><dt>Email</dt><dd>{{ $user->email }}</dd></div>
                <div class="kv"><dt>Peran</dt><dd><span class="pill">{{ ucfirst($user->role ?? 'Petugas') }}</span></dd></div>
                <div class="kv"><dt>Bergabung</dt><dd>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</dd></div>
            </dl>
        </div>

        <div class="box">
            <div class="box-head">Ganti kata sandi</div>
            <div class="box-body">
                <form action="{{ route('profil.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label for="current_password">Password lama</label>
                        <input type="password" name="current_password" id="current_password" autocomplete="current-password" required>
                        @error('current_password') <div class="err">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="password">Password baru</label>
                        <input type="password" name="password" id="password" autocomplete="new-password" required>
                        @error('password') <div class="err">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Konfirmasi password baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" required>
                    </div>

                    <label class="pick" style="padding-left: 0; margin-bottom: 18px !important; width: fit-content;">
                        <input type="checkbox" id="showPassword">
                        Tampilkan password
                    </label>

                    <button type="submit" class="btn">Simpan password baru</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('showPassword').addEventListener('change', function () {
            const type = this.checked ? 'text' : 'password';
            ['current_password', 'password', 'password_confirmation'].forEach(function (id) {
                document.getElementById(id).type = type;
            });
        });
    </script>
@endpush