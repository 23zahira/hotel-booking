@extends('layouts.app')
@section('title', 'Cari Kamar')
@section('content')
@if($errors->any())
    <div style="background:#7f1d1d;color:white;padding:16px;margin:20px 80px;border-radius:4px;">
        <strong>Error:</strong>
        <ul style="margin:8px 0 0 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('error'))
    <div style="background:#7f1d1d;color:white;padding:16px;margin:20px 80px;border-radius:4px;">
        {{ session('error') }}
    </div>
@endif

<style>
    .search-section { background: var(--dark-2); border-bottom: 1px solid rgba(201,168,76,0.15); padding: 40px 80px; }
    .search-title { font-family:'Playfair Display',serif; font-size: 28px; margin-bottom: 24px; }
    .search-form { display: flex; gap: 16px; align-items: flex-end; }
    .search-form .form-group { flex: 1; margin-bottom: 0; }
    .rooms-section { padding: 60px 80px; }
    .rooms-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; }
    .room-card { background: var(--dark-2); border: 1px solid rgba(201,168,76,0.15); border-radius: 4px; overflow: hidden; transition: transform 0.3s, border-color 0.3s; }
    .room-card:hover { transform: translateY(-4px); border-color: rgba(201,168,76,0.4); }
    .room-img { width:100%; height:200px; object-fit:cover; background:var(--dark-3); display:flex; align-items:center; justify-content:center; font-size:50px; }
    .room-body { padding: 24px; }
    .room-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
    .room-type { font-size: 11px; letter-spacing: 2px; color: var(--gold); text-transform: uppercase; margin-bottom: 4px; }
    .room-name { font-family: 'Playfair Display', serif; font-size: 20px; }
    .room-fasilitas { font-size: 12px; color: var(--text-muted); margin-bottom: 16px; line-height: 1.6; }
    .room-footer { display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid rgba(201,168,76,0.1); }
    .room-price { font-size: 18px; font-weight: 600; color: var(--gold); }
    .room-price small { font-size: 11px; color: var(--text-muted); font-weight: 400; }
    .room-locked { display: flex; align-items: center; gap: 6px; color: #ef4444; font-size: 12px; }
    .empty-state { text-align: center; padding: 80px 20px; color: var(--text-muted); }
    .empty-state .icon { font-size: 60px; margin-bottom: 20px; }
</style>

@if($mode !== 'lihat')
<!-- SEARCH: hanya muncul di mode booking -->
<section class="search-section">
    <h2 class="search-title">Cari Kamar</h2>
    <p style="color:var(--text-muted);font-size:13px;margin-bottom:24px;">Temukan kamar terbaik untuk Anda</p>
    <form method="GET" action="{{ route('kamar.index') }}">
        <div class="search-form">
            <div class="form-group">
                <label class="form-label">Check-in</label>
                <input type="date" name="checkin" id="checkin" class="form-input" value="{{ $checkin }}" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Lama Menginap</label>
                <select name="malam" id="malam" class="form-input">
                    @for($i = 1; $i <= 14; $i++)
                        <option value="{{ $i }}" {{ (isset($malam) && $malam == $i) ? 'selected' : '' }}>{{ $i }} Malam</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Check-out</label>
                <input type="text" id="checkout_display" class="form-input" readonly value="{{ $checkout }}">
                <input type="hidden" name="checkout" id="checkout" value="{{ $checkout }}">
            </div>
            <button type="submit" class="btn btn-gold" style="padding:12px 40px;">Cari Kamar</button>
        </div>
    </form>
    @if($checkin && $checkout)
        <p style="margin-top:16px;font-size:13px;color:var(--gold);">
            Menampilkan ketersediaan: {{ date('d M Y', strtotime($checkin)) }} — {{ date('d M Y', strtotime($checkout)) }}
        </p>
    @endif
</section>

<script>
    const checkinInput    = document.getElementById('checkin');
    const malamSelect     = document.getElementById('malam');
    const checkoutHidden  = document.getElementById('checkout');
    const checkoutDisplay = document.getElementById('checkout_display');

    function hitungCheckout() {
        if (!checkinInput.value) return;
        const d = new Date(checkinInput.value);
        d.setDate(d.getDate() + parseInt(malamSelect.value));
        const yyyy = d.getFullYear();
        const mm = String(d.getMonth() + 1).padStart(2, '0');
        const dd = String(d.getDate()).padStart(2, '0');
        checkoutHidden.value = `${yyyy}-${mm}-${dd}`;
        checkoutDisplay.value = `${dd}/${mm}/${yyyy}`;
    }

    checkinInput.addEventListener('change', hitungCheckout);
    malamSelect.addEventListener('change', hitungCheckout);

    if (!checkinInput.value) {
        checkinInput.value = new Date().toISOString().split('T')[0];
    }
    hitungCheckout();
</script>
@else
<!-- HEADER SEDERHANA: mode lihat kamar -->
<section class="search-section">
    <h2 class="search-title">Koleksi Kamar Kami</h2>
    <p style="color:var(--text-muted);font-size:13px;">Lihat seluruh kamar yang tersedia di Zanadisia Grand Hotel</p>
</section>
@endif

<!-- ROOMS -->
<section class="rooms-section">
    @if($kamars->count() > 0)
        <div class="rooms-grid">
            @foreach($kamars as $kamar)
            <div class="room-card" style="{{ ($mode !== 'lihat' && !$kamar->tersedia) ? 'opacity:0.6;' : '' }}">
                <div class="room-img">
                    @if($kamar->foto)
                        <img src="{{ asset('uploads/kamar/'.$kamar->foto) }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        🛏️
                    @endif
                </div>
                <div class="room-body">
                    <div class="room-header">
                        <div>
                            <div class="room-type">{{ $kamar->tipe_kamar }}</div>
                            <div class="room-name">Kamar {{ $kamar->nomor_kamar }}</div>
                        </div>
                        @if($mode !== 'lihat')
                           @if($kamar->status == 'tersedia')
                         <span class="badge badge-tersedia">Tersedia</span>

                        @elseif($kamar->status == 'nonaktif')
                        <span class="badge badge-dibatalkan">Nonaktif</span>

                        @elseif($kamar->status == 'perbaikan')
                        <span class="badge badge-menunggu">Perbaikan</span>

                    @else
                     <span class="badge badge-ditolak">Penuh</span>
                    @endif
                        @endif
                    </div>
                    <div class="room-fasilitas">{{ $kamar->fasilitas }}</div>
                    <div class="room-footer">
                        <div class="room-price">
                            Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}
                            <small>/ malam</small>
                        </div>

                        @if($mode !== 'lihat')
                            @if($kamar->status == 'tersedia')

    <div class="form-check">
        <input class="form-check-input kamar-checkbox"
               type="checkbox"
               value="{{ $kamar->id_kamar }}"
               id="kamar-{{ $kamar->id_kamar }}">
        <label class="form-check-label"
               for="kamar-{{ $kamar->id_kamar }}"
               style="font-size:12px;color:var(--gold);">
            Pilih Kamar
        </label>
    </div>

@else

    <div class="room-locked">🔒 Tidak Tersedia</div>

@endif
                        @endif
                        {{-- mode 'lihat': tidak ada tombol/aksi apapun di sini --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($mode === 'lihat')
            <div style="text-align:center;margin-top:48px;">
                <a href="{{ route('home') }}" class="btn btn-outline">← Kembali ke Beranda</a>
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="icon">🏨</div>
            <h3 style="font-family:'Playfair Display',serif;margin-bottom:8px;">Tidak Ada Kamar</h3>
            <p>Belum ada kamar yang tersedia saat ini.</p>
        </div>
    @endif
</section>

@if($mode !== 'lihat')
<div id="floating-bar" style="display:none; position:fixed; bottom:0; left:0; right:0; background:var(--dark-2); border-top:1px solid rgba(201,168,76,0.3); padding:16px 80px; text-align:right; z-index:999;">
    <form id="lanjutForm" action="{{ route('reservasi.pilih') }}" method="POST">
        @csrf
        <input type="hidden" name="checkin" id="floating_checkin">
        <input type="hidden" name="checkout" id="floating_checkout">
        <div id="hiddenKamarInputs"></div>
        <button type="submit" class="btn btn-gold" style="padding:14px 40px;">
            Lanjut Pesan (<span id="jumlahDipilih">0</span> kamar dipilih)
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes  = document.querySelectorAll('.kamar-checkbox');
    const floatingBar = document.getElementById('floating-bar');
    const jumlahSpan  = document.getElementById('jumlahDipilih');
    const hiddenInputs = document.getElementById('hiddenKamarInputs');
    const lanjutForm = document.getElementById('lanjutForm');
    const floatingCheckin = document.getElementById('floating_checkin');
    const floatingCheckout = document.getElementById('floating_checkout');

    function updateBar() {
        const checked = document.querySelectorAll('.kamar-checkbox:checked');
        jumlahSpan.textContent = checked.length;
        floatingBar.style.display = checked.length > 0 ? 'block' : 'none';

        hiddenInputs.innerHTML = '';
        checked.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id_kamar[]';
            input.value = cb.value;
            hiddenInputs.appendChild(input);
        });
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateBar));

    lanjutForm.addEventListener('submit', function () {
        floatingCheckin.value = document.getElementById('checkin').value;
        floatingCheckout.value = document.getElementById('checkout').value;
    });
});
</script>
@endif
@endsection