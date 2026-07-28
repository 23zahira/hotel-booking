@extends('layouts.app')
@section('title', 'Detail Pembayaran')

@section('content')
<style>
    .payment-container{
        padding:40px;
        background:var(--dark-1);
        min-height:100vh;
        color:white;
    }

    .card{
        background:var(--dark-2);
        border:1px solid rgba(201,168,76,0.2);
        padding:24px;
        border-radius:8px;
    }

    .title{
        font-family:'Playfair Display',serif;
        color:var(--gold);
        font-size:28px;
        margin-bottom:20px;
    }

    .row{
        margin-bottom:12px;
        font-size:14px;
    }

    .label{
        color:var(--text-muted);
    }

    .value{
        color:white;
        font-weight:500;
    }

    .kamar-item{
        border-bottom:1px solid rgba(255,255,255,0.05);
        padding:10px 0;
    }

    .img-bukti{
        margin-top:15px;
        width:300px;
        border-radius:6px;
        border:1px solid var(--gold);
    }

    .no-bukti-info{
        margin-top:8px;
        color:var(--text-muted);
        font-style:italic;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-valid, .status-dikonfirmasi { background: rgba(76,201,110,0.15); color: #4ec96e; }
    .status-menunggu, .status-menunggu_konfirmasi_pembayaran { background: rgba(201,168,76,0.15); color: var(--gold); }
    .status-ditolak, .status-dibatalkan { background: rgba(201,76,76,0.15); color: #e05c5c; }

    .btn-back{
        margin-top:20px;
        display:inline-block;
        color:var(--gold);
    }
</style>

<div class="payment-container">

    <div class="title">Detail Pembayaran</div>

    <div class="card">

        <div class="row">
            <span class="label">Kode Pesanan:</span>
            <div class="value">{{ $pembayaran->kode_pesanan }}</div>
        </div>

        <div class="row">
            <span class="label">Kamar:</span>
            @foreach($reservasiList as $r)
                <div class="kamar-item value">
                    {{ $r->kamar->tipe_kamar ?? '-' }} — Kamar {{ $r->kamar->nomor_kamar ?? '-' }}
                    <br>
                    <span style="font-size:12px;color:var(--text-muted);font-weight:400;">
                        {{ $r->tanggal_check_in }} s/d {{ $r->tanggal_check_out }} ({{ $r->total_malam }} malam)
                    </span>
                </div>
            @endforeach
        </div>

        <div class="row">
            <span class="label">Jumlah Bayar:</span>
            <div class="value">
                Rp {{ number_format($pembayaran->jumlah_bayar,0,',','.') }}
            </div>
        </div>

        <div class="row">
            <span class="label">Metode:</span>
            <div class="value">
                @php
                    $metodeMap = [
                        'virtual_account' => 'Virtual Account',
                        'qris'             => 'QRIS',
                    ];
                    $metodeTampil = $metodeMap[$pembayaran->metode_bayar] ?? $pembayaran->metode_bayar;
                @endphp
                {{ $metodeTampil }}
            </div>
        </div>

        <div class="row">
            <span class="label">Status:</span>
            <div class="value">
                <span class="status-badge status-{{ $pembayaran->status_bayar }}">
                    {{ ucfirst(str_replace('_', ' ', $pembayaran->status_bayar)) }}
                </span>
            </div>
        </div>

        <div class="row">
            <span class="label">Bukti Transfer:</span><br>
            @if($pembayaran->bukti_transfer)
                <img class="img-bukti"
                     src="{{ asset('uploads/bukti/'.$pembayaran->bukti_transfer) }}">
            @else
                <div class="no-bukti-info">
                    Tidak ada bukti transfer — pembayaran dikonfirmasi otomatis via {{ $metodeTampil }}.
                </div>
            @endif
        </div>

    </div>

    <a href="{{ route('reservasi.riwayat') }}" class="btn-back">
        ← Kembali
    </a>

</div>
@endsection