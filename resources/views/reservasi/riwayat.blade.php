@extends('layouts.app')

@section('title', 'Riwayat Reservasi')

@section('content')

<div style="max-width:900px; margin:40px auto; padding:0 20px;">

    <h2 style="font-family:'Playfair Display',serif; color:var(--text); margin-bottom:30px;">Riwayat Reservasi</h2>

    @forelse($reservasi as $r)

    <div style="background:var(--dark-2); border:1px solid rgba(201,168,76,0.15); border-radius:8px; margin-bottom:20px; overflow:hidden; display:flex; gap:0;">

        {{-- Foto kamar --}}
        <div style="width:200px; min-width:200px;">
            @if($r->kamar && $r->kamar->foto)
                <img src="{{ asset('uploads/kamar/' . $r->kamar->foto) }}"
                     style="width:100%; height:100%; object-fit:cover;" alt="Foto Kamar">
            @else
                <div style="width:100%; height:100%; min-height:140px; background:var(--dark-3); display:flex; align-items:center; justify-content:center; color:var(--text-muted); font-size:12px;">
                    No Image
                </div>
            @endif
        </div>

        {{-- Detail --}}
        <div style="padding:20px; flex:1;">
            <h4 style="font-family:'Playfair Display',serif; color:var(--text); margin-bottom:10px;">
                {{ $r->kamar->tipe_kamar ?? 'Kamar Tidak Ditemukan' }}
                @if($r->kamar) — Kamar {{ $r->kamar->nomor_kamar }} @endif
            </h4>

            <p style="color:var(--text-muted); font-size:13px; margin-bottom:4px;">
                Check-in: <span style="color:var(--text);">{{ date('d M Y', strtotime($r->tanggal_check_in)) }}</span>
            </p>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:4px;">
                Check-out: <span style="color:var(--text);">{{ date('d M Y', strtotime($r->tanggal_check_out)) }}</span>
            </p>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:4px;">
                Total: <span style="color:var(--gold); font-weight:600;">Rp {{ number_format($r->total_harga, 0, ',', '.') }}</span>
            </p>
           <p style="color:var(--text-muted); font-size:13px; margin-bottom:16px;">
                Status:
                @if($r->status == 'menunggu')
                    <span class="badge badge-menunggu">Menunggu Pembayaran</span>
                @elseif($r->status == 'menunggu_konfirmasi_pembayaran')
                    <span class="badge badge-menunggu">Menunggu Konfirmasi</span>
                @elseif($r->status == 'dikonfirmasi')
                    <span class="badge badge-dikonfirmasi">Dikonfirmasi</span>
                @elseif($r->status == 'selesai')
                    <span class="badge badge-selesai">Selesai</span>
                @elseif($r->status == 'dibatalkan')
                    <span class="badge badge-dibatalkan">Dibatalkan</span>
                @endif
            </p>

            {{-- Tombol --}}
            <div style="display:flex; gap:10px; flex-wrap:wrap;">

                <a href="{{ route('reservasi.show', $r->id_reservasi) }}" class="btn btn-outline btn-sm">
                    Lihat Detail
                </a>

             @if($r->status == 'menunggu')
                    <a href="{{ route('pembayaran.create', $r->kode_pesanan) }}" class="btn btn-gold btn-sm">
                        Bayar Sekarang
                    </a>
                @endif

                @if($r->status == 'selesai')
                    @php
                        $sudahUlasan = \App\Models\Ulasan::where('id_reservasi', $r->id_reservasi)
                            ->where('id_user', auth()->user()->id_user)
                            ->exists();
                    @endphp

                    @if(!$sudahUlasan)
                        <a href="{{ route('ulasan.create', $r->id_reservasi) }}" class="btn btn-gold btn-sm">
                            Beri Ulasan
                        </a>
                    @else
                        <button class="btn btn-sm" style="background:var(--dark-4); color:var(--text-muted); cursor:not-allowed;" disabled>
                            Sudah Diulas
                        </button>
                    @endif
                @endif

            </div>
        </div>

    </div>

    @empty

    <div style="background:var(--dark-2); border:1px solid rgba(201,168,76,0.15); border-radius:8px; padding:40px; text-align:center; color:var(--text-muted);">
        Belum ada riwayat reservasi.
    </div>

    @endforelse

    <div style="margin-top:20px;">
        <a href="{{ route('home') }}" class="btn btn-outline btn-sm">← Kembali ke Beranda</a>
    </div>

</div>

@endsection