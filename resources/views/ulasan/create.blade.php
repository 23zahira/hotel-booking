@extends('layouts.app')

@section('title', 'Beri Ulasan')

@section('content')

@push('styles')
<style>
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 8px;
}
.star-rating input[type="radio"] {
    display: none;
}
.star-rating label {
    font-size: 44px;
    cursor: pointer;
    color: var(--dark-4);
    transition: color 0.2s;
}
.star-rating input[type="radio"]:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: var(--gold);
}
</style>
@endpush

<div style="max-width: 700px; margin: 60px auto; padding: 0 20px;">

    <div class="section-title">Beri Ulasan</div>
    <div class="gold-line"></div>

    <div class="card" style="padding: 40px; margin-bottom: 24px;">
        <p style="color: var(--text-muted); font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Kamar yang dipesan</p>
        <p style="font-family: 'Playfair Display', serif; font-size: 22px; color: var(--gold); margin-top: 6px;">
            {{ $reservasi->kamar->tipe_kamar }} — No. {{ $reservasi->kamar->nomor_kamar }}
        </p>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">
            {{ \Carbon\Carbon::parse($reservasi->tanggal_check_in)->format('d M Y') }} —
            {{ \Carbon\Carbon::parse($reservasi->tanggal_check_out)->format('d M Y') }}
        </p>
    </div>

    <div class="card" style="padding: 40px;">
        <form action="{{ route('ulasan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_reservasi" value="{{ $reservasi->id_reservasi }}">

            {{-- Rating --}}
            <div class="form-group">
                <label class="form-label">Rating</label>
                <div class="star-rating">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                            {{ old('rating') == $i ? 'checked' : '' }}>
                        <label for="star{{ $i }}">★</label>
                    @endfor
                </div>
                @error('rating')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Komentar --}}
            <div class="form-group">
                <label class="form-label">Ulasan Anda</label>
                <textarea
                    name="komentar"
                    rows="6"
                    required
                    placeholder="Ceritakan pengalaman menginap Anda..."
                    class="form-input"
                    style="resize: vertical;"
                >{{ old('komentar') }}</textarea>
                @error('komentar')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-gold">Kirim Ulasan</button>
            <a href="{{ route('reservasi.riwayat') }}" class="btn btn-outline" style="margin-left: 12px;">Batal</a>

        </form>
    </div>

</div>

@endsection