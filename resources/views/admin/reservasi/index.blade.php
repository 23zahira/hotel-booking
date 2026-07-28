@extends('layouts.admin')
@section('title', 'Reservasi')
@section('page-title', 'Reservasi')
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

<div class="table-card">
    <div class="table-header">
        <h3>Daftar Reservasi</h3>
        <div style="display:flex;gap:12px;">
            <form method="GET" style="display:flex;gap:8px;">
               <select name="status" class="form-input" style="width:auto;" onchange="this.form.submit()">
    <option value="">Semua Status</option>
    <option value="menunggu_konfirmasi_pembayaran" {{ request('status')=='menunggu_konfirmasi_pembayaran'?'selected':'' }}>Menunggu Konfirmasi</option>
    <option value="dikonfirmasi" {{ request('status')=='dikonfirmasi'?'selected':'' }}>Dikonfirmasi</option>
    <option value="dibatalkan" {{ request('status')=='dibatalkan'?'selected':'' }}>Dibatalkan</option>
    <option value="selesai" {{ request('status')=='selesai'?'selected':'' }}>Selesai</option>
</select>
                <input type="text" name="search" class="form-input" placeholder="Cari nama tamu..." value="{{ request('search') }}" style="width:220px;">
                <button type="submit" class="btn btn-gold btn-sm">Cari</button>
            </form>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Tamu</th>
                <th>Kamar</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasis as $r)
            <tr>
                <td style="color:var(--gold);font-size:12px;">#{{ str_pad($r->id_reservasi, 4, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $r->user->nama ?? '-' }}</td>
                <td>{{ $r->kamar->tipe_kamar ?? '-' }}</td>
                <td>{{ date('d M Y', strtotime($r->tanggal_check_in)) }}</td>
                <td>{{ date('d M Y', strtotime($r->tanggal_check_out)) }}</td>
                <td>Rp {{ number_format($r->total_harga, 0, ',', '.') }}</td>
                <td>
                    <span class="badge badge-{{ $badgeClass[$r->status] ?? $r->status }}">
                        {{ $labelStatus[$r->status] ?? ucfirst($r->status) }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('admin.reservasi.show', $r->id_reservasi) }}" class="btn btn-outline btn-sm">Lihat</a>
                        <form method="POST" action="{{ route('admin.reservasi.status', $r->id_reservasi) }}">
                            @csrf
                            <select name="status" class="form-input" style="padding:4px 8px;font-size:11px;width:auto;" onchange="this.form.submit()">
                                <option value="menunggu" {{ $r->status=='menunggu'?'selected':'' }}>Menunggu</option>
                                <option value="dikonfirmasi" {{ $r->status=='dikonfirmasi'?'selected':'' }}>Konfirmasi</option>
                                <option value="selesai" {{ $r->status=='selesai'?'selected':'' }}>Selesai</option>
                                <option value="dibatalkan" {{ $r->status=='dibatalkan'?'selected':'' }}>Batalkan</option>
                            </select>
                        </form>
                        <form method="POST" action="{{ route('admin.reservasi.destroy', $r->id_reservasi) }}" id="del-res-{{ $r->id_reservasi }}">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('del-res-{{ $r->id_reservasi }}', 'Hapus reservasi ini?')">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:40px;">Tidak ada data reservasi.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:20px;">{{ $reservasis->links() }}</div>
</div>
@endsection