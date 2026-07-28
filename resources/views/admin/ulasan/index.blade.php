@extends('layouts.admin')
@section('title', 'Kelola Ulasan')
@section('page-title', 'Kelola Ulasan')
@section('content')

<style>
    table { width:100%; border-collapse:collapse; }
    thead tr { border-bottom:1px solid rgba(201,168,76,0.2); }
    thead th { padding:12px 16px; font-size:11px; letter-spacing:1.5px; text-transform:uppercase; color:var(--text-muted); font-weight:600; text-align:left; }
    tbody tr { border-bottom:1px solid rgba(255,255,255,0.04); transition:background 0.2s; }
    tbody tr:hover { background:rgba(201,168,76,0.04); }
    tbody td { padding:14px 16px; font-size:13px; color:var(--text); vertical-align:middle; }
    .rating-stars { color:var(--gold); font-size:14px; letter-spacing:2px; }
    .rating-empty { color:rgba(201,168,76,0.25); font-size:14px; letter-spacing:2px; }
</style>

<div class="table-card">
    <div class="table-header">
        <h3>Daftar Ulasan</h3>
        <span style="font-size:12px;color:var(--text-muted);">{{ $ulasans->total() }} ulasan</span>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tamu</th>
                <th>Kamar</th>
                <th>Rating</th>
                <th>Komentar</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ulasans as $u)
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $u->user->nama ?? '-' }}</div>
                </td>
                <td>
                    <div style="font-weight:600;">{{ $u->reservasi->kamar->tipe_kamar ?? '-' }}</div>
                    <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">No. {{ $u->reservasi->kamar->nomor_kamar ?? '-' }}</div>
                </td>
                <td>
                    <div style="display:flex;align-items:center;gap:4px;">
                        <span class="rating-stars">
                            @for($i = 1; $i <= $u->rating; $i++)★@endfor
                        </span>
                        <span class="rating-empty">
                            @for($i = $u->rating + 1; $i <= 5; $i++)★@endfor
                        </span>
                        <span style="font-size:11px;color:var(--text-muted);margin-left:4px;">{{ $u->rating }}/5</span>
                    </div>
                </td>
                <td style="max-width:260px;">
                    <div style="color:var(--text-muted);font-size:13px;line-height:1.5;">
                        {{ Str::limit($u->komentar, 80) }}
                    </div>
                </td>
                <td>
                    <div style="color:var(--text-muted);font-size:13px;">{{ date('d M Y', strtotime($u->tanggal)) }}</div>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.ulasan.destroy', $u->id_ulasan) }}" id="del-ulasan-{{ $u->id_ulasan }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="confirmDelete('del-ulasan-{{ $u->id_ulasan }}', 'Hapus ulasan ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;color:var(--text-muted);padding:60px 0;">
                    <div style="font-size:32px;margin-bottom:12px;">💬</div>
                    <div>Belum ada ulasan.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px 20px;border-top:1px solid rgba(201,168,76,0.1);">
        {{ $ulasans->links() }}
    </div>
</div>

@endsection