@extends('layouts.app')
@section('title', 'Pembayaran')
@section('content')
<style>
    .bayar-page { max-width: 700px; margin: 60px auto; padding: 0 20px; }
    .bayar-card { background: var(--dark-2); border: 1px solid rgba(201,168,76,0.2); border-radius: 4px; padding: 40px; }
    .bank-info { background: var(--dark-3); border: 1px solid rgba(201,168,76,0.2); border-radius: 4px; padding: 24px; margin-bottom: 32px; }
    .bank-header { display: flex; align-items: center; gap: 16px; margin-bottom: 16px; }
    .bank-logo { background: #003f88; color: white; padding: 8px 16px; border-radius: 4px; font-weight: 700; font-size: 14px; }
    .bank-number { font-size: 24px; font-weight: 700; letter-spacing: 2px; color: var(--text); margin-bottom: 4px; }
    .bank-name { font-size: 12px; color: var(--text-muted); }
    .total-bayar { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-top: 1px solid rgba(201,168,76,0.15); margin-top: 16px; }
    .total-bayar .label { font-size: 13px; color: var(--text-muted); }
    .total-bayar .amount { font-size: 22px; font-weight: 700; color: var(--gold); }
    .upload-area { border: 2px dashed rgba(201,168,76,0.3); border-radius: 4px; padding: 40px; text-align: center; cursor: pointer; transition: all 0.3s; margin-bottom: 24px; }
    .upload-area:hover { border-color: var(--gold); background: rgba(201,168,76,0.05); }
    .upload-area input[type=file] { display: none; }
    .upload-icon { font-size: 36px; margin-bottom: 12px; }
    .upload-text { font-size: 14px; color: var(--text-muted); }
    .upload-sub { font-size: 12px; color: var(--text-muted); margin-top: 4px; }
    .status-info { background: rgba(201,168,76,0.08); border: 1px solid rgba(201,168,76,0.2); border-radius: 4px; padding: 16px; text-align: center; font-size: 13px; color: var(--text-muted); }
    .status-info span { color: var(--gold); font-weight: 600; }
    .kamar-list { margin-bottom: 20px; }
    .kamar-list-item { display: flex; justify-content: space-between; font-size: 13px; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-muted); }

    /* Tab metode pembayaran */
    .metode-tabs { display: flex; gap: 12px; margin-bottom: 32px; }
    .metode-tab-btn {
        flex: 1; padding: 16px; text-align: center; cursor: pointer;
        background: var(--dark-3); border: 1px solid rgba(201,168,76,0.2); border-radius: 4px;
        font-size: 13px; color: var(--text-muted); transition: all 0.3s;
    }
    .metode-tab-btn.active {
        border-color: var(--gold); color: var(--gold); background: rgba(201,168,76,0.08);
    }
    .metode-tab-btn .tab-icon { font-size: 22px; display: block; margin-bottom: 6px; }
    .metode-panel { display: none; }
    .metode-panel.active { display: block; }
    .va-redirect-box { text-align: center; padding: 24px 0; }
    .va-redirect-box p { color: var(--text-muted); font-size: 13px; margin-bottom: 20px; }
</style>

<div class="bayar-page">
    <div style="margin-bottom:8px;font-size:11px;letter-spacing:2px;color:var(--gold);text-transform:uppercase;">Langkah 5 dari 5</div>
    <h1 style="font-family:'Playfair Display',serif;font-size:32px;margin-bottom:32px;">Pembayaran</h1>

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

        {{-- Pilihan metode --}}
        <div class="metode-tabs">
            <div class="metode-tab-btn active" id="tab-transfer" onclick="switchTab('transfer')">
                <span class="tab-icon">🏦</span>
                Transfer Bank
            </div>
            <div class="metode-tab-btn" id="tab-va" onclick="switchTab('va')">
                <span class="tab-icon">📱</span>
                Virtual Account / QRIS
            </div>
        </div>

        {{-- Panel Transfer Bank (form lama) --}}
        <div class="metode-panel active" id="panel-transfer">
            <h2 style="font-family:'Playfair Display',serif;font-size:22px;margin-bottom:16px;">Lakukan Transfer ke Rekening Berikut</h2>

            <div class="bank-info">
                <div class="bank-header">
                    <div class="bank-logo">BCA</div>
                    <div>
                        <div style="font-size:12px;color:var(--text-muted);">Bank Central Asia</div>
                    </div>
                </div>
                <div class="bank-number">1234 5678 9012</div>
                <div class="bank-name">a.n. ZANADASIA GRAND HOTEL</div>
                <div class="total-bayar">
                    <span class="label">Total Pembayaran ({{ $reservasiList->count() }} kamar)</span>
                    <span class="amount">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('pembayaran.store', $kode_pesanan) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="metode_bayar" class="form-input" required>
                        <option value="">Pilih Metode</option>
                        <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                        <option value="Transfer Bank BRI">Transfer Bank BRI</option>
                        <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                        <option value="Transfer Bank BNI">Transfer Bank BNI</option>
                        <option value="Transfer Bank BSI">Transfer Bank BSI</option>
                    </select>
                </div>

                <label class="form-label">Upload Bukti Transfer</label>
                <div class="upload-area" onclick="document.getElementById('bukti_input').click()">
                    <input type="file" id="bukti_input" name="bukti_transfer" accept=".jpg,.jpeg,.png" onchange="previewFile(this)">
                    <div class="upload-icon">📤</div>
                    <div class="upload-text">Klik atau drag & drop bukti transfer</div>
                    <div class="upload-sub">Format JPG, PNG (maks. 5MB)</div>
                    <div id="file-preview" style="margin-top:12px;display:none;">
                        <img id="preview-img" style="max-width:200px;max-height:150px;border-radius:4px;">
                        <p id="file-name" style="font-size:12px;color:var(--gold);margin-top:8px;"></p>
                    </div>
                </div>
                @error('bukti_transfer')<div class="form-error">{{ $message }}</div>@enderror

                <div class="status-info" style="margin-bottom:24px;">
                    Status akan berubah menjadi <span>Menunggu Konfirmasi</span> setelah transfer berhasil dikirim.
                </div>

                <button type="submit" class="btn btn-gold" style="width:100%;">Kirim Bukti Transfer</button>
            </form>
        </div>

        {{-- Panel Virtual Account / QRIS (redirect) --}}
        <div class="metode-panel" id="panel-va">
            <div class="va-redirect-box">
                <p>Bayar instan pakai Virtual Account atau QRIS.<br>Status pesanan akan otomatis terkonfirmasi setelah pembayaran.</p>
                <a href="{{ route('pembayaran.bayar', $kode_pesanan) }}" class="btn btn-gold" style="display:inline-block;padding:14px 40px;text-decoration:none;">
                    Lanjut ke Virtual Account / QRIS
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewFile(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('file-name').textContent = input.files[0].name;
            document.getElementById('file-preview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function switchTab(target) {
    document.getElementById('tab-transfer').classList.toggle('active', target === 'transfer');
    document.getElementById('tab-va').classList.toggle('active', target === 'va');
    document.getElementById('panel-transfer').classList.toggle('active', target === 'transfer');
    document.getElementById('panel-va').classList.toggle('active', target === 'va');
}
</script>
@endpush
@endsection