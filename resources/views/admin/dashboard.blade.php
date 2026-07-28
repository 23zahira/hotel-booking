@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('content')

@php
    $labelStatus = [
        'menunggu' => 'Menunggu Konfirmasi',
        'menunggu_konfirmasi_pembayaran' => 'Menunggu Konfirmasi',
        'dikonfirmasi' => 'Dikonfirmasi',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];

    $badgeClass = [
        'menunggu' => 'menunggu',
        'menunggu_konfirmasi_pembayaran' => 'menunggu',
        'dikonfirmasi' => 'dikonfirmasi',
        'selesai' => 'selesai',
        'dibatalkan' => 'dibatalkan',
    ];
@endphp

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Reservasi</div>
        <div class="stat-value">{{ $totalReservasi }}</div>
        <div class="stat-change">+12% dari bulan lalu</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Menunggu Konfirmasi</div>
        <div class="stat-value">{{ $menungguKonfirmasi }}</div>
        <div class="stat-change" style="color:#eab308;">Perlu tindakan</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Dikonfirmasi</div>
        <div class="stat-value">{{ $dikonfirmasi }}</div>
        <div class="stat-change">+5% dari bulan lalu</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Selesai</div>
        <div class="stat-value">{{ $selesai }}</div>
        <div class="stat-change">+10% dari bulan lalu</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    <div class="table-card">
        <div class="table-header">
            <h3>Reservasi Terbaru</h3>
            <a href="{{ route('admin.reservasi.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <table>
            <thead><tr><th>No. Pesanan</th><th>Tamu</th><th>Kamar</th><th>Status</th></tr></thead>
            <tbody>
                @foreach($reservasiTerbaru as $r)
                <tr>
                    <td style="color:var(--gold);font-size:12px;">#{{ str_pad($r->id_reservasi, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $r->user->nama ?? '-' }}</td>
                    <td>{{ $r->kamar->tipe_kamar ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $badgeClass[$r->status] ?? $r->status }}">
                            {{ $labelStatus[$r->status] ?? ucfirst($r->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="table-card">
        <div class="table-header">
            <h3>Aksi Cepat</h3>
        </div>
        <div style="padding:24px;display:flex;flex-direction:column;gap:12px;">
            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-gold" style="text-align:center;">💳 Verifikasi Pembayaran</a>
            <a href="{{ route('admin.reservasi.index') }}?status=menunggu_konfirmasi_pembayaran" class="btn btn-outline" style="text-align:center;">📋 Reservasi Menunggu</a>
            <a href="{{ route('admin.kamar.create') }}" class="btn btn-outline" style="text-align:center;">🛏️ Tambah Kamar Baru</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline" style="text-align:center;">👥 Kelola Tamu</a>
        </div>
    </div>
</div>
@endsection