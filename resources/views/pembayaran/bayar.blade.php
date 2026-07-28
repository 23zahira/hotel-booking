@extends('layouts.app')
@section('title', 'Pembayaran - Virtual Account / QRIS')
@section('content')
<style>
    .bayar-page { max-width: 700px; margin: 60px auto; padding: 0 20px; }
    .bayar-card { background: var(--dark-2); border: 1px solid rgba(201,168,76,0.2); border-radius: 4px; padding: 40px; }
    .kamar-list { margin-bottom: 20px; }
    .kamar-list-item { display: flex; justify-content: space-between; font-size: 13px; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-muted); }
    .total-bayar { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-top: 1px solid rgba(201,168,76,0.15); margin-top: 8px; margin-bottom: 32px; }
    .total-bayar .label { font-size: 13px; color: var(--text-muted); }
    .total-bayar .amount { font-size: 22px; font-weight: 700; color: var(--gold); }

    .metode-tabs { display: flex; gap: 12px; margin-bottom: 24px; }
    .metode-tab-btn {
        flex: 1; padding: 14px; text-align: center; cursor: pointer;
        background: var(--dark-3); border: 1px solid rgba(201,168,76,0.2); border-radius: 4px;
        font-size: 13px; color: var(--text-muted); transition: all 0.3s;
    }
    .metode-tab-btn.active { border-color: var(--gold); color: var(--gold); background: rgba(201,168,76,0.08); }

    .metode-panel { display: none; }
    .metode-panel.active { display: block; }

    .va-box { background: var(--dark-3); border: 1px solid rgba(201,168,76,0.2); border-radius: 4px; padding: 24px; margin-bottom: 24px; text-align: center; }
    .va-label { font-size: 12px; color: var(--text-muted); margin-bottom: 8px; }
    .va-number { font-size: 26px; font-weight: 700; letter-spacing: 2px; color: var(--gold); margin-bottom: 12px; word-break: break-all; }
    .copy-btn { background: transparent; border: 1px solid rgba(201,168,76,0.3); color: var(--text-muted); padding: 6px 16px; border-radius: 4px; font-size: 12px; cursor: pointer; }
    .copy-btn:hover { border-color: var(--gold); color: var(--gold); }

    .qris-box { text-align: center; margin-bottom: 24px; }
    .qris-box img { max-width: 220px; width: 100%; border: 1px solid rgba(201,168,76,0.2); border-radius: 4px; padding: 12px; background: #fff; }

    .status-info { background: rgba(201,168,76,0.08); border: 1px solid rgba(201,168,76,0.2); border-radius: 4px; padding: 16px; text-align: center; font-size: 13px; color: var(--text-muted); margin-bottom: 24px; }
    .status-info span { color: var(--gold); font-weight: 600; }

    .footnote { color: var(--text-muted); font-size: 12px; margin-top: 24px; text-align: center; }
</style>

<div class="bayar-page">
    <div style="margin-bottom:8px;font-size:11px;letter-spacing:2px;color:var(--gold);text-transform:uppercase;">Langkah 5 dari 5</div>
    <h1 style="font-family:'Playfair Display',serif;font-size:32px;margin-bottom:32px;">Virtual Account / QRIS</h1>

    <div class="bayar-card">
        <p style="color:var(--text-muted);font-size:13px;margin-bottom:20px;">Kode Pesanan: {{ $kode_pesanan }}</p>

        <div class="kamar-list">
            @foreach($reservasiList as $r)
                <div class="kamar-list-item">
                    <span>{{ $r->kamar->tipe_kamar }} — Kamar {{ $r->kamar->nomor_kamar }}</span>
                    <span>Rp {{ number_format($r->total_harga, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div class="total-bayar">
            <span class="label">Total Pembayaran ({{ $reservasiList->count() }} kamar)</span>
            <span class="amount">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
        </div>

        <div class="metode-tabs">
            <div class="metode-tab-btn active" id="tab-va" onclick="switchTab('va')">Virtual Account</div>
            <div class="metode-tab-btn" id="tab-qris" onclick="switchTab('qris')">QRIS</div>
        </div>

        {{-- Panel VA --}}
        <div class="metode-panel active" id="panel-va">
            <div class="va-box">
                <div class="va-label">Nomor Virtual Account</div>
                <div class="va-number" id="nomorVAText">{{ $nomorVA }}</div>
                <button type="button" class="copy-btn" onclick="copyVA()">Salin Nomor</button>
            </div>

            <form method="POST" action="{{ route('pembayaran.konfirmasiBayar', $kode_pesanan) }}"
                onsubmit="return confirm('Konfirmasi bahwa kamu sudah transfer ke nomor VA di atas?');">
                @csrf
                <input type="hidden" name="metode_bayar" value="virtual_account">
                <div class="status-info">
                    Status akan langsung berubah menjadi <span>Terkonfirmasi</span> setelah kamu menekan tombol di bawah.
                </div>
                <button type="submit" class="btn btn-gold" style="width:100%;">Saya Sudah Membayar</button>
            </form>
        </div>

        {{-- Panel QRIS --}}
        <div class="metode-panel" id="panel-qris">
            <div class="qris-box">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode('QRIS-DUMMY-'.$kode_pesanan) }}" alt="QRIS">
            </div>

            <form method="POST" action="{{ route('pembayaran.konfirmasiBayar', $kode_pesanan) }}"
                onsubmit="return confirm('Konfirmasi bahwa kamu sudah membayar via QRIS?');">
                @csrf
                <input type="hidden" name="metode_bayar" value="qris">
                <div class="status-info">
                    Status akan langsung berubah menjadi <span>Terkonfirmasi</span> setelah kamu menekan tombol di bawah.
                </div>
                <button type="submit" class="btn btn-gold" style="width:100%;">Saya Sudah Membayar</button>
            </form>
        </div>

        <p class="footnote">* Ini adalah simulasi pembayaran. Status pesanan akan otomatis terkonfirmasi setelah kamu menekan tombol "Saya Sudah Membayar".</p>
    </div>
</div>

@push('scripts')
<script>
function switchTab(target) {
    document.getElementById('tab-va').classList.toggle('active', target === 'va');
    document.getElementById('tab-qris').classList.toggle('active', target === 'qris');
    document.getElementById('panel-va').classList.toggle('active', target === 'va');
    document.getElementById('panel-qris').classList.toggle('active', target === 'qris');
}

function copyVA() {
    const text = document.getElementById('nomorVAText').innerText;
    navigator.clipboard.writeText(text).then(() => {
        alert('Nomor VA berhasil disalin');
    });
}
</script>
@endpush
@endsection