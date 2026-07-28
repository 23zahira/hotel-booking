@extends('layouts.admin')
@section('title', 'Tambah Kamar')
@section('page-title', 'Tambah Kamar')
@section('content')

<div style="max-width:600px;">
    <div class="table-card" style="padding:32px;">
        <h3 style="font-family:'Playfair Display',serif;font-size:22px;margin-bottom:28px;">Tambah Kamar Baru</h3>
        @if($errors->any())<div class="alert alert-error">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('admin.kamar.store') }}" enctype="multipart/form-data">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Nomor Kamar</label>
                    <input type="text" name="nomor_kamar" class="form-input" value="{{ old('nomor_kamar') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tipe Kamar</label>
                    <select name="tipe_kamar" class="form-input" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Superior">Superior</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Suite">Suite</option>
                        <option value="Presidential Suite">Presidential Suite</option>
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Harga per Malam (Rp)</label>
                    <input type="number" name="harga_per_malam" class="form-input" value="{{ old('harga_per_malam') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="perbaikan">Perbaikan</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Fasilitas</label>
                <textarea name="fasilitas" class="form-input" rows="3" placeholder="AC, Smart TV, WiFi, ...">{{ old('fasilitas') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Foto Kamar</label>
                <input type="file" name="foto" class="form-input" accept=".jpg,.jpeg,.png">
            </div>
            <div style="display:flex;gap:12px;">
                <a href="{{ route('admin.kamar.index') }}" class="btn btn-outline" style="flex:1;text-align:center;">Batal</a>
                <button type="submit" class="btn btn-gold" style="flex:2;">Simpan Kamar</button>
            </div>
        </form>
    </div>
</div>
@endsection