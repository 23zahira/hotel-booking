@extends('layouts.app')
@section('title', 'Lihat Kamar')
@section('content')
<style>
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
    .empty-state { text-align: center; padding: 80px 20px; color: var(--text-muted); }
    .empty-state .icon { font-size: 60px; margin-bottom: 20px; }
</style>

<div class="container" style="padding-top:60px;">
    <div class="text-center mb-5">
        <h1 style="font-family:'Playfair Display', serif; font-size:48px; color:white; margin-bottom:15px;">
            Daftar Kamar
        </h1>
        <p style="color:var(--text-muted); font-size:16px;">
            Jelajahi semua kamar yang tersedia di Zanadisia Grand Hotel.
        </p>
    </div>
</div>

<section class="rooms-section">
    @if($kamars->count() > 0)
        <div class="rooms-grid">
            @foreach($kamars as $kamar)
            <div class="room-card">
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
                        @if($kamar->tersedia)
                            <span class="badge badge-tersedia">Tersedia</span>
                        @else
                            <span class="badge badge-ditolak">Penuh</span>
                        @endif
                    </div>
                    <div class="room-fasilitas">{{ $kamar->fasilitas }}</div>
                    <div class="room-footer">
                        <div class="room-price">
                            Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}
                            <small>/ malam</small>
                        </div>
                        <a href="{{ route('kamar.show', $kamar->id_kamar) }}" class="btn btn-gold btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="icon">🏨</div>
            <h3 style="font-family:'Playfair Display',serif;margin-bottom:8px;">Tidak Ada Kamar</h3>
            <p>Belum ada kamar yang tersedia saat ini.</p>
        </div>
    @endif
</section>
@endsection