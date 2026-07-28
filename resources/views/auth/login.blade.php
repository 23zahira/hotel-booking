@extends('layouts.app')
@section('title', 'Login')
@section('content')
<style>
    .auth-page {
        min-height: calc(100vh - 72px);
        display: flex; align-items: center; justify-content: center;
        padding: 60px 20px;
        background: radial-gradient(ellipse at center, #1A1209 0%, #0D0D0D 70%);
    }
    .auth-container { display: flex; gap: 0; max-width: 900px; width: 100%; border: 1px solid rgba(201,168,76,0.2); border-radius: 4px; overflow: hidden; }
    .auth-side { flex: 1; background: linear-gradient(160deg, #1A1209, #0D0D0D); padding: 60px 40px; display: flex; flex-direction: column; justify-content: center; border-right: 1px solid rgba(201,168,76,0.15); }
    .auth-side-logo { font-family: 'Playfair Display', serif; font-size: 26px; color: var(--gold); margin-bottom: 32px; }
    .auth-side h2 { font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 16px; }
    .auth-side p { color: var(--text-muted); font-size: 14px; line-height: 1.7; }
    .auth-form { flex: 1; padding: 60px 40px; background: var(--dark-2); }
    .auth-form h3 { font-family: 'Playfair Display', serif; font-size: 26px; margin-bottom: 6px; }
    .auth-form p.sub { color: var(--text-muted); font-size: 13px; margin-bottom: 32px; }
    .auth-link { color: var(--gold); font-size: 13px; }
    .forgot { color: var(--text-muted); font-size: 12px; text-align: right; margin-top: 4px; }
    .divider { text-align: center; color: var(--text-muted); font-size: 12px; margin: 20px 0; position: relative; }
    .divider::before, .divider::after { content: ''; position: absolute; top: 50%; width: 42%; height: 1px; background: rgba(201,168,76,0.15); }
    .divider::before { left: 0; } .divider::after { right: 0; }
    .guest-btn { width: 100%; padding: 12px; background: transparent; border: 1px solid rgba(201,168,76,0.2); color: var(--text-muted); border-radius: 2px; cursor: pointer; font-size: 13px; font-family: 'Inter', sans-serif; transition: all 0.3s; }
    .guest-btn:hover { border-color: var(--gold); color: var(--gold); }
</style>
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-side">
            <div class="auth-side-logo">⬡ ZANADISIA GRAND</div>
            <h2>Selamat<br>Datang Kembali</h2>
            <p>Masuk ke akun Anda untuk melanjutkan perjalanan kemewahan bersama kami.</p>
        </div>
        <div class="auth-form">
            <h3>Login</h3>
            <p class="sub">Selamat kembali!</p>
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                    <div class="forgot"><a href="#" class="auth-link">Lupa password?</a></div>
                </div>
                <button type="submit" class="btn btn-gold" style="width:100%;margin-bottom:16px;">Masuk</button>
            </form>
            <div class="divider">atau</div>
            <a href="{{ route('kamar.index') }}">
                <button class="guest-btn">Masuk Sebagai Tamu</button>
            </a>
            <p style="text-align:center;margin-top:24px;font-size:13px;color:var(--text-muted);">
                Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection