@extends('layouts.admin')
@section('title', 'Kelola Tamu')
@section('page-title', 'Kelola Tamu')
@section('content')

<div class="table-card">
    <div class="table-header">
        <h3>Daftar Tamu</h3>
    </div>
    <table>
        <thead>
            <tr><th>Nama</th><th>Email</th><th>No. Telepon</th><th>Role</th><th>Terdaftar</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($users as $u)
            <tr>
                <td>{{ $u->nama }}</td>
                <td style="color:var(--text-muted);">{{ $u->email }}</td>
                <td>{{ $u->no_telepon ?? '-' }}</td>
                <td><span class="badge {{ $u->role === 'admin' ? 'badge-valid' : 'badge-selesai' }}">{{ ucfirst($u->role) }}</span></td>
                <td style="color:var(--text-muted);">{{ date('d M Y', strtotime($u->created_at)) }}</td>
                <td>
                    @if($u->role !== 'admin')
                    <form method="POST" action="{{ route('admin.users.destroy', $u->id_user) }}" id="del-user-{{ $u->id_user }}">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('del-user-{{ $u->id_user }}', 'Hapus user {{ $u->nama }}?')">Hapus</button>
                    </form>
                    @else
                    <span style="color:var(--text-muted);font-size:12px;">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:40px;">Belum ada tamu terdaftar.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:20px;">{{ $users->links() }}</div>
</div>
@endsection