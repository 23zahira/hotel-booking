@extends('layouts.app')
@section('title', 'Konfirmasi Pesanan')
@section('content')
<style>
    .konfirmasi-page { max-width: 700px; margin: 60px auto; padding: 0 20px; }
    .summary-card { background: var(--dark-2); border: 1px solid rgba(201,168,76,0.2); border-radius: 4px; padding: 40px; }
    .summary-header { text-align: center; padding-bottom: 32px; border-bottom: 1px solid rgba(201,168,76,0.15); margin-bottom: 32px; }
    .summary-header h2 { font-family:'Playfair Display',serif; font-size:28px; margin-bottom:8px; }
    .summary-header p { color: var(--text-muted); font-size: 13px; }
    .summary-room { display: flex; gap: 20px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid rgba(201,168,76,0.15); }
    .summary-room-img { width: 120px; height: 90px; background: var(--dark-3); border-radius: 2px; display:flex;align-items:center;justify-content:center;font-size:30px;flex-shrink:0; }
    .summary-room-info h3 { font-family:'Playfair Display',serif; font-size:20px; margin-bottom:6px; }
    .summary-room-info p { color:var(--text-muted); font-size:13px; }
    .summary-room-subtotal { margin-top:8px; font-size:13px; color:var(--gold); }
    .summary-rows { margin: 32px 0; }
    .summary-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 14px; }
    .summary-row:last-child { border-bottom: none; }
    .summary-row .label { color: var(--text-muted); }
    .summary-total { display: flex; justify-content: space-between; padding: 20px; background: rgba(201,168,76,0.08); border: 1px solid rgba(201,168,76,0.2); border-radius: 2px; margin-bottom: 32px; }
    .summary-total .label { font-size: 16px; font-weight: 600; }
    .summary-total .value { font-size: 24px; font-weight: 700; color: var(--gold); }
    .summary-actions { display: flex; gap: 12px; }
</style>

<div class="konfirmasi-page">
    <div style="margin-bottom:8px;font-size:11px;letter-spacing:2px;color:var(--gold);text-transform:uppercase;">Langkah 3 dari 5</div>
    <h1 style="font-family:'Playfair Display',serif;font-size:32px;margin-bottom:32px;">Ringkasan Pesanan</h1>

    <div class="summary-card">
        <div class="summary-header">
            <h2>Konfirmasi Pesanan</h2>
            <p>{{ $kamarList->count() }} kamar dipilih — Kode Pesanan: {{ $kodePesanan }}</p>
        </div>

        @foreach($kamarList as $kamar)
        <div class="summary-room">
            <div class="summary-room-img">
                @if($kamar->foto)
                    <img src="{{ asset('uploads/kamar/'.$kamar->foto) }}" style="width:100%;height:100%;object-fit:cover;border-radius:2px;">
                @else
                    🛏️
                @endif
            </div>
            <div class="summary-room-info">
                <h3>{{ $kamar->tipe_kamar }} — Kamar {{ $kamar->nomor_kamar }}</h3>
                <p>{{ $kamar->fasilitas }}</p>
                <p class="summary-room-subtotal">
                    Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }} x {{ $totalMalam }} malam
                    = Rp {{ number_format($kamar->harga_per_malam * $totalMalam, 0, ',', '.') }}
                </p>
            </div>
        </div>
        @endforeach

        <div class="summary-rows">
            <div class="summary-row">
                <span class="label">Check-in</span>
                <span>{{ $checkin->format('d M Y') }}</span>
            </div>
            <div class="summary-row">
                <span class="label">Check-out</span>
                <span>{{ $checkout->format('d M Y') }}</span>
            </div>
            <div class="summary-row">
                <span class="label">Jumlah Malam</span>
                <span>{{ $totalMalam }} Malam</span>
            </div>
            <div class="summary-row">
                <span class="label">Subtotal ({{ $kamarList->count() }} kamar)</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span class="label">Pajak & Service (10%)</span>
                <span>Rp {{ number_format($pajak, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="summary-total">
            <span class="label">TOTAL</span>
            <span class="value">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</span>
        </div>

        <form method="POST" action="{{ route('reservasi.store') }}">
            @csrf
            <input type="hidden" name="kode_pesanan" value="{{ $kodePesanan }}">
            <input type="hidden" name="tanggal_check_in" value="{{ $checkin->format('Y-m-d') }}">
            <input type="hidden" name="tanggal_check_out" value="{{ $checkout->format('Y-m-d') }}">
            @foreach($kamarList as $kamar)
                <input type="hidden" name="id_kamar[]" value="{{ $kamar->id_kamar }}">
            @endforeach
            <div class="summary-actions">
                <a href="{{ route('kamar.index') }}" class="btn btn-outline" style="flex:1;text-align:center;">Ubah Pilihan</a>
                <button type="submit" class="btn btn-gold" style="flex:2;">Konfirmasi Pesanan</button>
            </div>
        </form>
    </div>
</div>
@endsection