@extends('layouts.app')

@section('title', 'Profil Anggota')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Beranda</a>
    <svg class="i" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Profil</span>
@endsection

@section('hero')
    <div class="hero-sub">
        <span class="avatar">{{ Str::upper(Str::substr($member->name, 0, 1)) }}</span>
        {{ ucfirst($member->role ?? 'Anggota') }}
    </div>
    <h1>{{ $member->name }}</h1>
    <div class="meta"><span>{{ $member->email }}</span></div>
@endsection

@section('content')
    <div class="form-narrow">
        <div class="box" style="margin-bottom: 28px;">
            <div class="box-head">Informasi akun</div>
            <dl>
                <div class="kv"><dt>Nama</dt><dd>{{ $member->nama }}</dd></div>
                <div class="kv"><dt>Email</dt><dd>{{ $member->email }}</dd></div>
                <div class="kv"><dt>Peran</dt><dd><span class="pill">{{ ucfirst($member->role ?? 'Anggota') }}</span></dd></div>
                <div class="kv"><dt>Bergabung</dt><dd>{{ $member->created_at ? $member->created_at->format('d M Y') : '-' }}</dd></div>
            </dl>
        </div>

        <div class="reset-password-section">
            <h4>Pemulihan Akun</h4>
            <p>Jika anggota lupa password, Anda dapat meresetnya menjadi password bawaan sistem (<strong>perpus123</strong>).</p>
            
            <form action="{{ route('members.reset-password', $member->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset password anggota ini menjadi perpus123?')">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-warning">
                    Reset Password
                </button>
            </form>
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