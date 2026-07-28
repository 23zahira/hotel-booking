@extends('layouts.app')
@section('title', 'Detail Reservasi')

@section('content')

<style>
    .detail-page {
        display: flex;
        min-height: calc(100vh - 72px);
    }

    .content {
        flex: 1;
        padding: 48px;
    }

    .card-box {
        background: var(--dark-2);
        border: 1px solid rgba(201,168,76,0.15);
        border-radius: 4px;
        padding: 24px;
    }

    .room-img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 16px;
        background: var(--dark-3);
    }

    .title {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        margin-bottom: 6px;
    }

    .info {
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 8px;
    }

    .info span {
        color: white;
    }

    .price {
        font-size: 22px;
        font-weight: 700;
        color: var(--gold);
        margin-top: 10px;
    }

    .btn-group {
        margin-top: 18px;
        display: flex;
        gap: 10px;
    }
</style>

<div class="detail-page">

    <div class="content">

        <div class="card-box">

            {{-- GAMBAR (SUDAH AMAN + FALLBACK) --}}
            @if($reservasi->kamar && $reservasi->kamar->foto)
                <img src="{{ asset('uploads/kamar/'.$reservasi->kamar->foto) }}" class="room-img">
            @else
                <img src="https://via.placeholder.com/800x400?text=No+Image" class="room-img">
            @endif

            <div class="title">
                {{ $reservasi->kamar->tipe_kamar ?? '-' }}
                — Kamar {{ $reservasi->kamar->nomor_kamar ?? '-' }}
            </div>

            <div class="info">
                Check-in: <span>{{ $reservasi->tanggal_check_in }}</span>
            </div>

            <div class="info">
                Check-out: <span>{{ $reservasi->tanggal_check_out }}</span>
            </div>

            <div class="info">
                Lama menginap: <span>{{ $reservasi->total_malam }} malam</span>
            </div>

            <div class="info">
                Status: <span>{{ ucfirst($reservasi->status) }}</span>
            </div>

            <hr style="border-color: rgba(201,168,76,0.15);">

            <div class="price">
                Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}
            </div>

            {{-- TOMBOL: PAKAI kode_pesanan, BUKAN id_reservasi --}}
            <div class="btn-group">

                <a href="{{ route('reservasi.riwayat') }}" class="btn btn-outline btn-sm">
                    ← Kembali
                </a>

                @if($reservasi->pembayaran)
                    <a href="{{ route('pembayaran.show', $reservasi->kode_pesanan) }}"
                       class="btn btn-gold btn-sm">
                        💳 Lihat Pembayaran
                    </a>
                @else
                    <a href="{{ route('pembayaran.create', $reservasi->kode_pesanan) }}"
                       class="btn btn-gold btn-sm">
                        💳 Bayar Sekarang
                    </a>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection