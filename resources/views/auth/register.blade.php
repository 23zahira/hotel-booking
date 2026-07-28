@extends('layouts.app')
@section('title', 'Register')
@section('content')
<style>
    .auth-page { min-height: calc(100vh - 72px); display: flex; align-items: center; justify-content: center; padding: 60px 20px; background: radial-gradient(ellipse at center, #1A1209 0%, #0D0D0D 70%); }
    .auth-container { display: flex; max-width: 900px; width: 100%; border: 1px solid rgba(201,168,76,0.2); border-radius: 4px; overflow: hidden; }
    .auth-side { flex: 1; background: linear-gradient(160deg, #1A1209, #0D0D0D); padding: 60px 40px; display: flex; flex-direction: column; justify-content: center; border-right: 1px solid rgba(201,168,76,0.15); }
    .auth-side-logo { font-family: 'Playfair Display', serif; font-size: 26px; color: var(--gold); margin-bottom: 32px; }
    .auth-side h2 { font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 16px; }
    .auth-side p { color: var(--text-muted); font-size: 14px; line-height: 1.7; }
    .auth-form { flex: 1; padding: 60px 40px; background: var(--dark-2); }
    .auth-form h3 { font-family: 'Playfair Display', serif; font-size: 26px; margin-bottom: 6px; }
    .auth-form p.sub { color: var(--text-muted); font-size: 13px; margin-bottom: 32px; }
    .auth-link { color: var(--gold); font-size: 13px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
</style>
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-side">
            <div class="auth-side-logo">⬡ ZANADISIA GRAND </div>
            <h2>Buat Akun<br>Baru</h2>
            <p>Bergabunglah dengan ribuan tamu kami dan nikmati pengalaman menginap yang tak terlupakan.</p>
        </div>
        <div class="auth-form">
            <h3>Register</h3>
            <p class="sub">Buat akun baru</p>
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-input" placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="no_telepon" class="form-input" placeholder="08xxxxxxxxxx" value="{{ old('no_telepon') }}">
                </div>
                <button type="submit" class="btn btn-gold" style="width:100%;">Daftar</button>
            </form>
            <p style="text-align:center;margin-top:24px;font-size:13px;color:var(--text-muted);">
                Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection