@extends('layouts.admin')
@section('title', 'Detail Reservasi')
@section('page-title', 'Detail Reservasi')

@section('content')

<div style="max-width:800px;">

    {{-- INFO RESERVASI --}}
    <div class="table-card" style="margin-bottom:20px;">
        <div class="table-header">
            <h3>Informasi Reservasi</h3>
        </div>
        <div style="padding:24px; display:grid; grid-template-columns:1fr 1fr; gap:16px;">

            <div>
                <div style="font-size:11px; letter-spacing:1px; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Kamar</div>
                <div style="color:var(--text); font-weight:600;">
                    {{ $reservasi->kamar->tipe_kamar ?? '-' }} — No. {{ $reservasi->kamar->nomor_kamar ?? '-' }}
                </div>
            </div>

            <div>
                <div style="font-size:11px; letter-spacing:1px; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Nama Tamu</div>
                <div style="color:var(--text);">{{ $reservasi->user->nama ?? '-' }}</div>
            </div>

            <div>
                <div style="font-size:11px; letter-spacing:1px; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Check-in</div>
                <div style="color:var(--text);">{{ date('d M Y', strtotime($reservasi->tanggal_check_in)) }}</div>
            </div>

            <div>
                <div style="font-size:11px; letter-spacing:1px; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Check-out</div>
                <div style="color:var(--text);">{{ date('d M Y', strtotime($reservasi->tanggal_check_out)) }}</div>
            </div>

            <div>
                <div style="font-size:11px; letter-spacing:1px; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Lama Menginap</div>
                <div style="color:var(--text);">{{ $reservasi->total_malam }} malam</div>
            </div>

            <div>
                <div style="font-size:11px; letter-spacing:1px; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Total Harga</div>
                <div style="color:var(--gold); font-weight:700; font-size:16px;">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</div>
            </div>

            <div>
                <div style="font-size:11px; letter-spacing:1px; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Status Reservasi</div>
                <div>
                    @if($reservasi->status == 'menunggu')
                        <span class="badge badge-menunggu">Menunggu</span>
                    @elseif($reservasi->status == 'menunggu_konfirmasi_pembayaran')
                        <span class="badge badge-menunggu">Menunggu Konfirmasi</span>
                    @elseif($reservasi->status == 'dikonfirmasi')
                        <span class="badge badge-dikonfirmasi">Dikonfirmasi</span>
                    @elseif($reservasi->status == 'selesai')
                        <span class="badge badge-selesai">Selesai</span>
                    @elseif($reservasi->status == 'dibatalkan')
                        <span class="badge badge-dibatalkan">Dibatalkan</span>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- DATA PEMBAYARAN --}}
    <div class="table-card" style="margin-bottom:20px;">
        <div class="table-header">
            <h3>Data Pembayaran</h3>
        </div>
        <div style="padding:24px;">
            @if($reservasi->pembayaran)
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                <div>
                    <div style="font-size:11px; letter-spacing:1px; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Metode</div>
                    <div style="color:var(--text);">{{ $reservasi->pembayaran->metode_bayar ?? '-' }}</div>
                </div>

                <div>
                    <div style="font-size:11px; letter-spacing:1px; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Jumlah Bayar</div>
                    <div style="color:var(--gold); font-weight:700;">Rp {{ number_format($reservasi->pembayaran->jumlah_bayar, 0, ',', '.') }}</div>
                </div>

                <div>
                    <div style="font-size:11px; letter-spacing:1px; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Status Pembayaran</div>
                    <div>
                        @if($reservasi->pembayaran->status_bayar == 'valid')
                            <span class="badge badge-dikonfirmasi">Valid</span>
                        @elseif($reservasi->pembayaran->status_bayar == 'ditolak')
                            <span class="badge badge-dibatalkan">Ditolak</span>
                        @else
                            <span class="badge badge-menunggu">Menunggu</span>
                        @endif
                    </div>
                </div>

            </div>

            {{-- BUKTI TRANSFER --}}
            @if($reservasi->pembayaran->bukti_transfer)
            <div style="margin-top:24px;">
                <div style="font-size:11px; letter-spacing:1px; color:var(--text-muted); text-transform:uppercase; margin-bottom:8px;">Bukti Transfer</div>
                <img src="{{ asset('uploads/bukti/' . $reservasi->pembayaran->bukti_transfer) }}"
                     style="max-width:300px; border-radius:4px; border:1px solid rgba(201,168,76,0.2);">
            </div>
            @endif

            {{-- TOMBOL VERIFIKASI (hanya muncul jika masih menunggu) --}}
            @if($reservasi->pembayaran->status_bayar == 'menunggu')
            <div style="margin-top:28px; display:flex; gap:12px;">
                <form method="POST" action="{{ route('admin.pembayaran.konfirmasi', $reservasi->pembayaran->id_pembayaran) }}">
                    @csrf
                    
                    <button type="submit" class="btn btn-gold btn-sm">✓ Konfirmasi Pembayaran</button>
                </form>
                <form method="POST" action="{{ route('admin.pembayaran.tolak', $reservasi->pembayaran->id_pembayaran) }}">
                    @csrf
                    
                    <button type="submit" class="btn btn-outline btn-sm" style="color:#e74c3c; border-color:#e74c3c;">✕ Tolak Pembayaran</button>
                </form>
            </div>
            @endif

            @else
            <div style="color:var(--text-muted); font-size:14px;">Belum ada data pembayaran.</div>
            @endif
        </div>
    </div>

    {{-- TOMBOL KEMBALI --}}
    <a href="{{ route('admin.reservasi.index') }}" class="btn btn-outline btn-sm">← Kembali</a>

</div>

@endsection