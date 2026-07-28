@extends('layouts.admin')
@section('title', 'Kelola Kamar')
@section('page-title', 'Kelola Kamar')
@section('content')

<div class="table-card">
    <div class="table-header">
        <h3>Daftar Kamar</h3>
        <a href="{{ route('admin.kamar.create') }}" class="btn btn-gold">+ Tambah Kamar</a>
    </div>
    <table>
        <thead>
            <tr><th>No. Kamar</th><th>Tipe</th><th>Harga/Malam</th><th>Fasilitas</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($kamars as $k)
            <tr>
                <td style="font-weight:600;">{{ $k->nomor_kamar }}</td>
                <td>{{ $k->tipe_kamar }}</td>
                <td>Rp {{ number_format($k->harga_per_malam, 0, ',', '.') }}</td>
                <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text-muted);">{{ $k->fasilitas }}</td>
                <td><span class="badge badge-{{ $k->status === 'tersedia' ? 'dikonfirmasi' : 'menunggu' }}">{{ ucfirst($k->status) }}</span></td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('admin.kamar.edit', $k->id_kamar) }}" class="btn btn-outline btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.kamar.destroy', $k->id_kamar) }}" id="del-kamar-{{ $k->id_kamar }}">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('del-kamar-{{ $k->id_kamar }}', 'Hapus kamar {{ $k->nomor_kamar }}?')">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:40px;">Belum ada kamar.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:20px;">{{ $kamars->links() }}</div>
</div>
@endsection