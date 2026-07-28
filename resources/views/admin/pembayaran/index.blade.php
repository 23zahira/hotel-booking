@extends('layouts.admin')
@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Verifikasi Pembayaran')
@section('content')

<div class="table-card">
    <div class="table-header">
        <h3>Daftar Pembayaran</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Kode Pesanan</th>
                <th>Tamu</th>
                <th>Kamar</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayarans as $p)
            <tr>
                <td style="color:var(--gold);font-size:12px;">{{ $p->kode_pesanan }}</td>
                <td>{{ $p->reservasiList->first()->user->nama ?? '-' }}</td>
                <td>
                    @foreach($p->reservasiList as $r)
                        <div style="font-size:12px;">{{ $r->kamar->tipe_kamar ?? '-' }} ({{ $r->kamar->nomor_kamar ?? '-' }})</div>
                    @endforeach
                </td>
                <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                <td>
                    @php
                        $metodeMap = [
                            'virtual_account' => 'Virtual Account',
                            'qris'             => 'QRIS',
                        ];
                    @endphp
                    {{ $metodeMap[$p->metode_bayar] ?? $p->metode_bayar }}
                </td>
                <td><span class="badge badge-{{ $p->status_bayar }}">{{ ucfirst($p->status_bayar) }}</span></td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('admin.pembayaran.show', $p->id_pembayaran) }}" class="btn btn-outline btn-sm">Detail</a>
                        @if($p->status_bayar === 'menunggu')
                            <form method="POST" action="{{ route('admin.pembayaran.konfirmasi', $p->id_pembayaran) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
                            </form>
                            <form method="POST" action="{{ route('admin.pembayaran.tolak', $p->id_pembayaran) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.pembayaran.destroy', $p->id_pembayaran) }}" id="del-pay-{{ $p->id_pembayaran }}">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('del-pay-{{ $p->id_pembayaran }}', 'Hapus data pembayaran ini?')">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">Tidak ada data pembayaran.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:20px;">{{ $pembayarans->links() }}</div>
</div>
@endsection