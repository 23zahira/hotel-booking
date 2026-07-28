@extends('layouts.app')

@section('title', 'Ulasan Saya')

@section('content')

<div class="container" style="max-width:900px;margin:40px auto;">

    <h1 style="margin-bottom:30px;">Ulasan Saya</h1>

    @if(session('success'))
        <div style="background:#d1fae5;color:#065f46;padding:15px;border-radius:8px;margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @forelse($ulasans as $ulasan)

        <div style="background:#fff;padding:25px;border-radius:10px;margin-bottom:20px;box-shadow:0 2px 10px rgba(0,0,0,0.08);color:#1a1a1a;">

            <div style="margin-bottom:10px;">
                <strong>Rating:</strong>
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $ulasan->rating)
                        ⭐
                    @else
                        ☆
                    @endif
                @endfor
            </div>

            <div style="margin-bottom:10px;">
                <strong>Komentar:</strong>
                <p>{{ $ulasan->komentar }}</p>
            </div>

            @if($ulasan->reservasi && $ulasan->reservasi->kamar)
                <div>
                    <strong>Kamar:</strong>
                    {{ $ulasan->reservasi->kamar->tipe_kamar }}
                </div>
            @endif

        </div>

    @empty

        <div style="background:#fff;padding:30px;border-radius:10px;text-align:center;">
            Belum ada ulasan.
        </div>

    @endforelse

    <div style="margin-top:20px;">
        <a href="{{ route('home') }}" class="btn btn-outline btn-sm">← Kembali ke Beranda</a>
    </div>

</div>

@endsection