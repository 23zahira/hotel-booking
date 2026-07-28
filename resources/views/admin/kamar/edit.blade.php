@extends('layouts.admin')
@section('title', 'Edit Kamar')
@section('page-title', 'Edit Kamar')
@section('content')

<div style="max-width:600px;">
    <div class="table-card" style="padding:32px;">
        <h3 style="font-family:'Playfair Display',serif;font-size:22px;margin-bottom:28px;">Edit Kamar {{ $kamar->nomor_kamar }}</h3>
        @if($errors->any())<div class="alert alert-error">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('admin.kamar.update', $kamar->id_kamar) }}" enctype="multipart/form-data">
            @csrf 
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Nomor Kamar</label>
                    <input type="text" name="nomor_kamar" class="form-input" value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tipe Kamar</label>
                    <select name="tipe_kamar" class="form-input" required>
                        @foreach(['Superior','Deluxe','Suite','Presidential Suite'] as $tipe)
                            <option value="{{ $tipe }}" {{ $kamar->tipe_kamar == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Harga per Malam (Rp)</label>
                    <input type="number" name="harga_per_malam" class="form-input" value="{{ old('harga_per_malam', $kamar->harga_per_malam) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input" required>
                        @foreach(['tersedia','perbaikan','nonaktif'] as $s)
                            <option value="{{ $s }}" {{ $kamar->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Fasilitas</label>
                <textarea name="fasilitas" class="form-input" rows="3">{{ old('fasilitas', $kamar->fasilitas) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Foto Kamar (kosongkan jika tidak diubah)</label>
                @if($kamar->foto)
                    <img src="{{ asset('uploads/kamar/'.$kamar->foto) }}" style="width:100px;height:75px;object-fit:cover;border-radius:4px;margin-bottom:8px;display:block;">
                @endif
                <input type="file" name="foto" class="form-input" accept=".jpg,.jpeg,.png">
            </div>
            <div style="display:flex;gap:12px;">
                <a href="{{ route('admin.kamar.index') }}" class="btn btn-outline" style="flex:1;text-align:center;">Batal</a>
                <button type="submit" class="btn btn-gold" style="flex:2;">Update Kamar</button>
            </div>
        </form>
    </div>
</div>
@endsection