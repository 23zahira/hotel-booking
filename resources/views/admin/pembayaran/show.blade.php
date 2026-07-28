@extends('layouts.admin')
@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')
@section('content')

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;max-width:900px;">
    <div class="table-card" style="padding:32px;">
        <h3 style="font-family:'Playfair Display',serif;font-size:20px;margin-bottom:24px;">Informasi Reservasi</h3>
        <div style="display:flex;flex-direction:column;gap:16px;">
            <div><div class="form-label">Kode Pesanan</div><div style="color:var(--gold);">{{ $pembayaran->kode_pesanan }}</div></div>
            <div><div class="form-label">Tamu</div><div>{{ $reservasiList->first()->user->nama ?? '-' }}</div></div>

            <div>
                <div class="form-label">Kamar Dipesan ({{ $reservasiList->count() }})</div>
                @foreach($reservasiList as $r)
                    <div style="padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.05);">
                        {{ $r->kamar->tipe_kamar ?? '-' }} — Kamar {{ $r->kamar->nomor_kamar ?? '-' }}
                        <span style="color:var(--text-muted);font-size:12px;"> (Rp {{ number_format($r->total_harga, 0, ',', '.') }})</span>
                    </div>
                @endforeach
            </div>

            <div><div class="form-label">Check-in</div><div>{{ date('d M Y', strtotime($reservasiList->first()->tanggal_check_in)) }}</div></div>
            <div><div class="form-label">Check-out</div><div>{{ date('d M Y', strtotime($reservasiList->first()->tanggal_check_out)) }}</div></div>
            <div><div class="form-label">Total Pembayaran</div><div style="font-size:20px;font-weight:700;color:var(--gold);">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</div></div>
            <div><div class="form-label">Metode</div><div>{{ $pembayaran->metode_bayar }}</div></div>
            <div><div class="form-label">Status</div><span class="badge badge-{{ $pembayaran->status_bayar }}">{{ ucfirst($pembayaran->status_bayar) }}</span></div>
        </div>

       @if($pembayaran->status_bayar === 'menunggu')
       <div style="display:flex;gap:12px;margin-top:32px;">
        <form method="POST" action="{{ route('admin.pembayaran.konfirmasi', $pembayaran->id_pembayaran) }}" style="flex:1;">
        @csrf
        <button type="submit" class="btn btn-success" style="width:100%;">✓ Konfirmasi Pembayaran</button>
    </form>
    <form method="POST" action="{{ route('admin.pembayaran.tolak', $pembayaran->id_pembayaran) }}" style="flex:1;">
        @csrf
        <button type="submit" class="btn btn-danger" style="width:100%;">✗ Tolak Pembayaran</button>
     </form>
    </div>
    @endif
</div>

    <div class="table-card" style="padding:32px;">
        <h3 style="font-family:'Playfair Display',serif;font-size:20px;margin-bottom:24px;">Bukti Transfer</h3>
        @if($pembayaran->bukti_transfer)
            <img src="{{ asset('uploads/bukti/'.$pembayaran->bukti_transfer) }}" style="width:100%;border-radius:4px;border:1px solid rgba(201,168,76,0.2);">
        @else
            <div style="text-align:center;padding:40px;color:var(--text-muted);">Tidak ada bukti transfer</div>
        @endif
    </div>
</div>

<div style="margin-top:24px;">
    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-outline">← Kembali</a>
</div>
@endsection