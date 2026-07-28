<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Zanadisia Grand</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --gold:#C9A84C; --gold-light:#E8C97A; --dark:#0D0D0D; --dark-2:#1A1A1A; --dark-3:#252525; --dark-4:#2E2E2E; --text:#F5F0E8; --text-muted:#9E9E9E; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background:var(--dark); color:var(--text); font-family:'Inter',sans-serif; display:flex; min-height:100vh; }
        a { color:inherit; text-decoration:none; }

        /* SIDEBAR */
        .admin-sidebar { width: 240px; background: var(--dark-2); border-right: 1px solid rgba(201,168,76,0.15); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; }
        .sidebar-logo { padding: 28px 24px; border-bottom: 1px solid rgba(201,168,76,0.15); font-family:'Playfair Display',serif; color:var(--gold); font-size:16px; letter-spacing:1px; }
        .sidebar-section { padding: 20px 0; border-bottom: 1px solid rgba(201,168,76,0.08); }
        .sidebar-section-label { padding: 0 24px 8px; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: rgba(158,158,158,0.5); }
        .sidebar-nav a { display:flex; align-items:center; gap:12px; padding:11px 24px; font-size:13px; color:var(--text-muted); transition:all 0.2s; }
        .sidebar-nav a:hover, .sidebar-nav a.active { color:var(--gold); background:rgba(201,168,76,0.05); border-right:2px solid var(--gold); }
        .sidebar-nav a .icon { width:18px; text-align:center; font-size:14px; }

        /* MAIN */
        .admin-main { margin-left: 240px; flex: 1; }
        .admin-topbar { background: var(--dark-2); border-bottom: 1px solid rgba(201,168,76,0.15); padding: 16px 40px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; }
        .admin-topbar h2 { font-family:'Playfair Display',serif; font-size:20px; }
        .admin-user { display:flex; align-items:center; gap:12px; font-size:13px; color:var(--text-muted); }
        .admin-content { padding: 40px; }

        /* NOTIFIKASI */
        .topbar-right { display:flex; align-items:center; gap:20px; }
        .notif-bell { position:relative; cursor:pointer; font-size:18px; padding:8px; border-radius:50%; transition:background 0.2s; }
        .notif-bell:hover { background:rgba(201,168,76,0.1); }
        .notif-badge { position:absolute; top:2px; right:2px; background:#ef4444; color:white; font-size:10px; font-weight:700; min-width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center; padding:0 4px; }
        .notif-badge.hidden { display:none; }
        @keyframes shake {
            0%, 100% { transform: rotate(0); }
            20% { transform: rotate(15deg); }
            40% { transform: rotate(-15deg); }
            60% { transform: rotate(10deg); }
            80% { transform: rotate(-10deg); }
        }
        .notif-bell.shake { animation: shake 0.5s ease-in-out; }

        /* STATS */
        .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:40px; }
        .stat-card { background:var(--dark-2); border:1px solid rgba(201,168,76,0.15); border-radius:4px; padding:24px; }
        .stat-label { font-size:11px; letter-spacing:1px; text-transform:uppercase; color:var(--text-muted); margin-bottom:12px; }
        .stat-value { font-family:'Playfair Display',serif; font-size:36px; color:var(--text); margin-bottom:4px; }
        .stat-change { font-size:12px; color:var(--gold); }

        /* TABLE */
        .table-card { background:var(--dark-2); border:1px solid rgba(201,168,76,0.15); border-radius:4px; overflow:hidden; }
        .table-header { padding:20px 24px; border-bottom:1px solid rgba(201,168,76,0.15); display:flex; justify-content:space-between; align-items:center; }
        .table-header h3 { font-family:'Playfair Display',serif; font-size:18px; }
        table { width:100%; border-collapse:collapse; }
        th { padding:12px 20px; text-align:left; font-size:11px; letter-spacing:1px; text-transform:uppercase; color:var(--text-muted); border-bottom:1px solid rgba(201,168,76,0.15); background:rgba(201,168,76,0.03); }
        td { padding:14px 20px; font-size:13px; border-bottom:1px solid rgba(255,255,255,0.04); }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:rgba(201,168,76,0.02); }

        /* MISC */
        .badge { display:inline-block; padding:5px 14px; border-radius:20px; font-size:11px; font-weight:600; white-space:nowrap; line-height:1.4; }
        .badge-menunggu { background:rgba(234,179,8,0.15); color:#eab308; }
        .badge-dikonfirmasi { background:rgba(34,197,94,0.15); color:#22c55e; }
        .badge-dibatalkan { background:rgba(239,68,68,0.15); color:#ef4444; }
        .badge-selesai { background:rgba(59,130,246,0.15); color:#3b82f6; }
        .badge-valid { background:rgba(34,197,94,0.15); color:#22c55e; }
        .badge-ditolak { background:rgba(239,68,68,0.15); color:#ef4444; }
        .btn { display:inline-block; padding:10px 22px; border-radius:2px; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase; cursor:pointer; border:none; transition:all 0.3s; font-family:'Inter',sans-serif; }
        .btn-gold { background:var(--gold); color:var(--dark); }
        .btn-gold:hover { background:var(--gold-light); }
        .btn-outline { background:transparent; border:1px solid var(--gold); color:var(--gold); }
        .btn-outline:hover { background:var(--gold); color:var(--dark); }
        .btn-danger { background:#dc2626; color:white; }
        .btn-danger:hover { background:#b91c1c; }
        .btn-success { background:#16a34a; color:white; }
        .btn-sm { padding:6px 14px; font-size:11px; }
        .form-input { width:100%; padding:10px 14px; background:var(--dark-3); border:1px solid rgba(201,168,76,0.2); border-radius:2px; color:var(--text); font-size:13px; font-family:'Inter',sans-serif; }
        .form-input:focus { outline:none; border-color:var(--gold); }
        .form-label { display:block; font-size:11px; letter-spacing:1px; color:var(--text-muted); margin-bottom:6px; text-transform:uppercase; }
        .form-group { margin-bottom:20px; }
        .alert { padding:12px 16px; border-radius:2px; margin-bottom:20px; font-size:13px; }
        .alert-success { background:rgba(201,168,76,0.1); border:1px solid var(--gold); color:var(--gold); }
        .alert-error { background:rgba(220,38,38,0.1); border:1px solid #dc2626; color:#f87171; }
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:9999; align-items:center; justify-content:center; }
        .modal-overlay.active { display:flex; }
        .modal-box { background:var(--dark-2); border:1px solid rgba(201,168,76,0.3); border-radius:4px; padding:32px; max-width:420px; width:90%; text-align:center; }
        .modal-box h3 { font-family:'Playfair Display',serif; color:var(--gold); margin-bottom:12px; }
        .modal-box p { color:var(--text-muted); font-size:14px; margin-bottom:24px; }
        .modal-actions { display:flex; gap:12px; justify-content:center; }
        .pagination { display:flex; gap:8px; justify-content:center; margin-top:24px; }
        .pagination a, .pagination span { padding:7px 13px; border-radius:2px; font-size:12px; background:var(--dark-3); border:1px solid rgba(201,168,76,0.15); color:var(--text-muted); }
        .pagination .active span { background:var(--gold); color:var(--dark); border-color:var(--gold); }
    </style>
    @stack('styles')
</head>
<body>

<aside class="admin-sidebar">
    <div class="sidebar-logo">⬡ ZANADISIA GRAND<br><small style="font-size:10px;color:var(--text-muted);font-family:'Inter',sans-serif;letter-spacing:2px;">ADMIN PANEL</small></div>
    <div class="sidebar-section">
        <div class="sidebar-section-label">Utama</div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="icon">📊</span> Dashboard</a>
            <a href="{{ route('admin.reservasi.index') }}" class="{{ request()->routeIs('admin.reservasi.*') ? 'active' : '' }}"><span class="icon">📋</span> Reservasi</a>
            <a href="{{ route('admin.pembayaran.index') }}" class="{{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}"><span class="icon">💳</span> Pembayaran</a>
        </nav>
    </div>
    <div class="sidebar-section">
        <div class="sidebar-section-label">Kelola</div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.kamar.index') }}" class="{{ request()->routeIs('admin.kamar.*') ? 'active' : '' }}"><span class="icon">🛏️</span> Kamar</a>
            <a href="{{ route('admin.ulasan.index') }}" class="{{ request()->routeIs('admin.ulasan.*') ? 'active' : '' }}"><span class="icon">⭐</span> Ulasan</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><span class="icon">👥</span> Tamu</a>
        </nav>
    </div>
    <div class="sidebar-section">
        <div class="sidebar-section-label">Akun</div>
        <nav class="sidebar-nav">
            <a href="{{ route('home') }}"><span class="icon">🌐</span> Lihat Website</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" style="width:100%;background:none;border:none;cursor:pointer;font-family:'Inter',sans-serif;">
                    <span style="display:flex;align-items:center;gap:12px;padding:11px 24px;font-size:13px;color:#ef4444;">
                        <span class="icon">🚪</span> Keluar
                    </span>
                </button>
            </form>
        </nav>
    </div>
</aside>

<div class="admin-main">
    <div class="admin-topbar">
        <h2>@yield('page-title', 'Dashboard')</h2>
        <div class="topbar-right">
            <a href="{{ route('admin.reservasi.index') }}?status=menunggu_konfirmasi_pembayaran" class="notif-bell" id="notif-bell">
                🔔
                <span id="notif-badge" class="notif-badge hidden">0</span>
            </a>
            <div class="admin-user">
                <span>{{ auth()->user()->nama }}</span>
                <span style="background:rgba(201,168,76,0.15);color:var(--gold);padding:4px 10px;border-radius:20px;font-size:11px;">Admin</span>
            </div>
        </div>
    </div>

    <div class="admin-content">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
        @yield('content')
    </div>
</div>

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

<audio id="notif-sound" src="{{ asset('sounds/notif.mp3') }}" preload="auto"></audio>

<script>
function confirmDelete(formId, msg) {
    document.getElementById('confirmMessage').textContent = msg || 'Yakin hapus data ini?';
    document.getElementById('confirmModal').classList.add('active');
    document.getElementById('confirmYes').onclick = () => document.getElementById(formId).submit();
}
function closeModal() { document.getElementById('confirmModal').classList.remove('active'); }

let lastNotifCount = null;

function updateNotifBadge() {
    fetch("{{ route('admin.notifikasi.count') }}")
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('notif-badge');
            const bell = document.getElementById('notif-bell');

            if (data.jumlah > 0) {
                badge.textContent = data.jumlah;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }

            const isFirstCheck = lastNotifCount === null;
            const bertambah = lastNotifCount !== null && data.jumlah > lastNotifCount;

            if ((isFirstCheck && data.jumlah > 0) || bertambah) {
                document.getElementById('notif-sound').play().catch(() => {});
                bell.classList.add('shake');
                setTimeout(() => bell.classList.remove('shake'), 500);
            }

            lastNotifCount = data.jumlah;
        })
        .catch(err => console.error('Gagal cek notifikasi:', err));
}

updateNotifBadge();
setInterval(updateNotifBadge, 15000);
</script>
@stack('scripts')
</body>
</html>