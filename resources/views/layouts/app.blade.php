<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Zanadisia Grand Hotel')</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C97A;
            --dark: #0D0D0D;
            --dark-2: #1A1A1A;
            --dark-3: #252525;
            --dark-4: #2E2E2E;
            --text: #F5F0E8;
            --text-muted: #9E9E9E;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--dark); color: var(--text); font-family: 'Inter', sans-serif; }
        a { color: inherit; text-decoration: none; }

        /* NAVBAR */
        nav {
            position: fixed; top: 0; width: 100%; z-index: 1000;
            background: rgba(13,13,13,0.95);
            border-bottom: 1px solid rgba(201,168,76,0.2);
            padding: 16px 40px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 20px; color: var(--gold); letter-spacing: 2px;
        }
        .nav-links { display: flex; gap: 32px; align-items: center; }
        .nav-links a { font-size: 13px; letter-spacing: 1px; color: var(--text-muted); transition: color 0.3s; }
        .nav-links a:hover { color: var(--gold); }
        .nav-btn {
            background: var(--gold); color: var(--dark);
            padding: 10px 24px; border-radius: 2px;
            font-size: 12px; font-weight: 600; letter-spacing: 1.5px;
            text-transform: uppercase; transition: background 0.3s;
        }
        .nav-btn:hover { background: var(--gold-light); }
        .nav-dropdown { position: relative; }
        .nav-dropdown-menu {
            display: none; position: absolute; right: 0; top: 100%;
            background: var(--dark-2); border: 1px solid rgba(201,168,76,0.2);
            min-width: 180px; padding: 8px 0; border-radius: 2px;
        }
        .nav-dropdown:hover .nav-dropdown-menu { display: block; }
        .nav-dropdown-menu a {
            display: block; padding: 10px 20px; font-size: 13px;
            color: var(--text-muted); transition: all 0.2s;
        }
        .nav-dropdown-menu a:hover { color: var(--gold); background: var(--dark-3); }

        /* NOTIFIKASI */
        .notif-wrapper { position: relative; }
        .notif-bell {
            position: relative; cursor: pointer; font-size: 18px;
            color: var(--text-muted); transition: color 0.3s;
            padding: 8px; display: inline-block;
        }
        .notif-bell:hover { color: var(--gold); }
        .notif-badge {
            position: absolute; top: 0; right: 0;
            background: #dc2626; color: white;
            font-size: 10px; font-weight: 700;
            min-width: 16px; height: 16px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            padding: 0 3px; line-height: 1;
        }
        .notif-menu {
            display: none; position: absolute; right: 0; top: 100%;
            background: var(--dark-2); border: 1px solid rgba(201,168,76,0.2);
            width: 320px; max-height: 400px; overflow-y: auto;
            padding: 0; border-radius: 2px; margin-top: 4px;
        }
        .notif-wrapper:hover .notif-menu { display: block; }
        .notif-header {
            padding: 12px 16px; font-size: 12px; letter-spacing: 1px;
            text-transform: uppercase; color: var(--gold);
            border-bottom: 1px solid rgba(201,168,76,0.15);
            display: flex; justify-content: space-between; align-items: center;
        }
        .notif-header button {
            background: none; border: none; color: var(--text-muted);
            font-size: 11px; cursor: pointer; text-transform: none; letter-spacing: 0;
        }
        .notif-header button:hover { color: var(--gold); }
        .notif-item {
            display: block; padding: 12px 16px; border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: background 0.2s;
        }
        .notif-item:hover { background: var(--dark-3); }
        .notif-item.unread { background: rgba(201,168,76,0.05); }
        .notif-item .notif-judul { font-size: 13px; color: var(--text); font-weight: 600; margin-bottom: 4px; }
        .notif-item .notif-pesan { font-size: 12px; color: var(--text-muted); line-height: 1.4; }
        .notif-item .notif-waktu { font-size: 11px; color: var(--text-muted); margin-top: 4px; opacity: 0.7; }
        .notif-empty { padding: 24px 16px; text-align: center; font-size: 13px; color: var(--text-muted); }

        /* MAIN */
        main { padding-top: 72px; min-height: 100vh; }

        /* ALERT */
        .alert {
            padding: 14px 20px; border-radius: 2px; margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success { background: rgba(201,168,76,0.1); border: 1px solid var(--gold); color: var(--gold); }
        .alert-error { background: rgba(220,38,38,0.1); border: 1px solid #dc2626; color: #f87171; }

        /* BTN */
        .btn {
            display: inline-block; padding: 12px 28px; border-radius: 2px;
            font-size: 13px; font-weight: 600; letter-spacing: 1.5px;
            text-transform: uppercase; cursor: pointer; border: none;
            transition: all 0.3s;
        }
        .btn-gold { background: var(--gold); color: var(--dark); }
        .btn-gold:hover { background: var(--gold-light); }
        .btn-outline { background: transparent; border: 1px solid var(--gold); color: var(--gold); }
        .btn-outline:hover { background: var(--gold); color: var(--dark); }
        .btn-danger { background: #dc2626; color: white; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-sm { padding: 8px 18px; font-size: 11px; }

        /* CARD */
        .card {
            background: var(--dark-2); border: 1px solid rgba(201,168,76,0.15);
            border-radius: 4px; overflow: hidden;
        }

        /* FORM */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase; }
        .form-input {
            width: 100%; padding: 12px 16px; background: var(--dark-3);
            border: 1px solid rgba(201,168,76,0.2); border-radius: 2px;
            color: var(--text); font-size: 14px; font-family: 'Inter', sans-serif;
            transition: border-color 0.3s;
        }
        .form-input:focus { outline: none; border-color: var(--gold); }
        .form-error { color: #f87171; font-size: 12px; margin-top: 4px; }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; }
        th { padding: 12px 16px; text-align: left; font-size: 11px; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); border-bottom: 1px solid rgba(201,168,76,0.15); }
        td { padding: 14px 16px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        tr:hover td { background: rgba(201,168,76,0.03); }

        /* BADGE */
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; letter-spacing: 0.5px; }
        .badge-menunggu { background: rgba(234,179,8,0.15); color: #eab308; }
        .badge-dikonfirmasi { background: rgba(34,197,94,0.15); color: #22c55e; }
        .badge-dibatalkan { background: rgba(239,68,68,0.15); color: #ef4444; }
        .badge-selesai { background: rgba(59,130,246,0.15); color: #3b82f6; }
        .badge-valid { background: rgba(34,197,94,0.15); color: #22c55e; }
        .badge-ditolak { background: rgba(239,68,68,0.15); color: #ef4444; }
        .badge-tersedia { background: rgba(34,197,94,0.15); color: #22c55e; }
        .badge-perbaikan { background: rgba(234,179,8,0.15); color: #eab308; }

        /* FOOTER */
        footer {
            background: var(--dark-2); border-top: 1px solid rgba(201,168,76,0.15);
            padding: 40px; text-align: center; color: var(--text-muted); font-size: 13px;
        }
        footer .footer-logo { font-family: 'Playfair Display', serif; color: var(--gold); font-size: 22px; margin-bottom: 12px; }

        /* MODAL */
        .modal-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7);
            z-index: 9999; align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: var(--dark-2); border: 1px solid rgba(201,168,76,0.3);
            border-radius: 4px; padding: 32px; max-width: 420px; width: 90%; text-align: center;
        }
        .modal-box h3 { font-family: 'Playfair Display', serif; color: var(--gold); margin-bottom: 12px; }
        .modal-box p { color: var(--text-muted); font-size: 14px; margin-bottom: 24px; }
        .modal-actions { display: flex; gap: 12px; justify-content: center; }

        /* SECTION */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px; color: var(--text); margin-bottom: 8px;
        }
        .section-subtitle { color: var(--text-muted); font-size: 14px; margin-bottom: 40px; }
        .gold-line { width: 60px; height: 2px; background: var(--gold); margin: 12px 0 32px; }

        /* PAGINATION */
        .pagination { display: flex; gap: 8px; justify-content: center; margin-top: 32px; }
        .pagination a, .pagination span {
            padding: 8px 14px; border-radius: 2px; font-size: 13px;
            background: var(--dark-3); border: 1px solid rgba(201,168,76,0.15); color: var(--text-muted);
        }
        .pagination .active span { background: var(--gold); color: var(--dark); border-color: var(--gold); }
    </style>
    @stack('styles')
</head>
<body>
<nav>
    <div class="nav-logo">⬡ ZANADISIA GRAND</div>
    <div class="nav-links">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('kamar.index') }}">Kamar</a>
        <a href="{{ route('fasilitas') }}">Fasilitas</a>
        <a href="{{ route('tentang') }}">Tentang</a>
        @auth
            <div class="notif-wrapper">
                <a href="#" class="notif-bell">
                    🔔
                    @if(($unreadCount ?? 0) > 0)
                        <span class="notif-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </a>
                <div class="notif-menu">
                    <div class="notif-header">
                        <span>Notifikasi</span>
                        @if(($unreadCount ?? 0) > 0)
                            <form method="POST" action="{{ route('notifikasi.readAll') }}">
                                @csrf
                                <button type="submit">Tandai semua dibaca</button>
                            </form>
                        @endif
                    </div>
                    @forelse(($notifications ?? []) as $notif)
                        <a href="{{ route('notifikasi.read', $notif->id) }}" class="notif-item {{ $notif->status === 'belum_dibaca' ? 'unread' : '' }}">
                            <div class="notif-judul">{{ $notif->judul }}</div>
                            <div class="notif-pesan">{{ $notif->pesan }}</div>
                            <div class="notif-waktu">{{ $notif->created_at->diffForHumans() }}</div>
                        </a>
                    @empty
                        <div class="notif-empty">Belum ada notifikasi</div>
                    @endforelse
                </div>
            </div>
            <div class="nav-dropdown">
                <a href="#" style="color: var(--gold);">Halo, {{ auth()->user()->nama }} ▾</a>
                <div class="nav-dropdown-menu">
                    <a href="{{ route('reservasi.riwayat') }}">Riwayat Pesanan</a>
                    <a href="{{ route('ulasan.index') }}">Ulasan Saya</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" style="color: var(--gold);">Panel Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="width:100%; text-align:left; padding: 10px 20px; background:none; border:none; cursor:pointer; font-size:13px; color:#ef4444; font-family:'Inter',sans-serif;">Keluar</button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('kamar.index') }}" class="nav-btn">Mulai Booking</a>
        @endauth
    </div>
</nav>

<main>
    @if(session('success'))
        <div style="position:fixed;top:80px;right:20px;z-index:999;max-width:360px;">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div style="position:fixed;top:80px;right:20px;z-index:999;max-width:360px;">
            <div class="alert alert-error">{{ session('error') }}</div>
        </div>
    @endif
    @yield('content')
</main>

<footer>
    <div class="footer-logo">⬡ ZANADISIA GRAND</div>
    <p>Experience Pure Luxury · Crafting exceptional stays with passion and precision.</p>
    <p style="margin-top:8px;">© {{ date('Y') }} Zanadisia Grand Hotel. All rights reserved.</p>
</footer>

<script>
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(a => a.style.display = 'none');
    }, 4000);

    function confirmDelete(formId, message) {
        document.getElementById('confirmMessage').textContent = message || 'Apakah Anda yakin ingin menghapus data ini?';
        document.getElementById('confirmModal').classList.add('active');
        document.getElementById('confirmYes').onclick = function() {
            document.getElementById(formId).submit();
        };
    }
    function closeModal() {
        document.getElementById('confirmModal').classList.remove('active');
    }
</script>

<div id="confirmModal" class="modal-overlay">
    <div class="modal-box">
        <h3>Konfirmasi Hapus</h3>
        <p id="confirmMessage">Apakah Anda yakin?</p>
        <div class="modal-actions">
            <button onclick="closeModal()" class="btn btn-outline btn-sm">Batal</button>
            <button id="confirmYes" class="btn btn-danger btn-sm">Ya, Hapus</button>
        </div>
    </div>
</div>

@stack('scripts')
</body>
</html>