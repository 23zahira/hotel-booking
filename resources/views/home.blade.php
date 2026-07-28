@extends('layouts.app')
@section('title', 'Zanadisia Grand Hotel')
@section('content')

<style>
    .hero {
        height: 100vh; position: relative; overflow: hidden;
        display: flex; align-items: center;
        background: linear-gradient(135deg, #0D0D0D 0%, #1A1209 50%, #0D0D0D 100%);
    }
    .hero-bg {
        position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1600') center/cover;
        opacity: 0.25;
    }
    .hero-content { position: relative; z-index: 1; padding: 0 80px; max-width: 700px; }
    .hero-eyebrow { font-size: 11px; letter-spacing: 4px; color: var(--gold); text-transform: uppercase; margin-bottom: 24px; }
    .hero-title { font-family: 'Playfair Display', serif; font-size: 72px; line-height: 1.1; margin-bottom: 24px; }
    .hero-title span { color: var(--gold); }
    .hero-sub { color: var(--text-muted); font-size: 16px; line-height: 1.7; margin-bottom: 40px; max-width: 480px; }
    .hero-actions { display: flex; gap: 16px; }

    .features {
        padding: 100px 80px;
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px;
        background: rgba(201,168,76,0.1);
    }
    .feature-item {
        background: var(--dark); padding: 48px 40px; text-align: center;
    }
    .feature-icon { font-size: 36px; margin-bottom: 20px; }
    .feature-title { font-family: 'Playfair Display', serif; font-size: 20px; margin-bottom: 10px; color: var(--gold); }
    .feature-desc { color: var(--text-muted); font-size: 14px; line-height: 1.6; }

    .rooms-section { padding: 100px 80px; }
    .rooms-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
    .room-card { background: var(--dark-2); border: 1px solid rgba(201,168,76,0.15); overflow: hidden; border-radius: 4px; transition: transform 0.3s; }
    .room-card:hover { transform: translateY(-4px); }
    .room-img { width: 100%; height: 220px; object-fit: cover; background: var(--dark-3); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 40px; }
    .room-body { padding: 24px; }
    .room-type { font-size: 11px; letter-spacing: 2px; color: var(--gold); text-transform: uppercase; margin-bottom: 8px; }
    .room-name { font-family: 'Playfair Display', serif; font-size: 22px; margin-bottom: 12px; }
    .room-price { font-size: 18px; color: var(--gold); font-weight: 600; margin-bottom: 16px; }
    .room-price span { font-size: 12px; color: var(--text-muted); font-weight: 400; }
</style>

<!-- HERO -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <p class="hero-eyebrow">✦ Zanadisia Grand Hotel</p>
        <h1 class="hero-title">Experience<br><span>Pure Luxury</span></h1>
        <p class="hero-sub">Crafting exceptional stays with passion and precision. Every detail curated for the discerning traveler.</p>
        <div class="hero-actions">
            <a href="{{ route('kamar.index') }}" class="btn btn-gold">Mulai Booking</a>
            <a href="{{ route('kamar.index', ['mode' => 'lihat']) }}" class="btn btn-outline">Lihat Kamar</a>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features">
    <div class="feature-item">
        <div class="feature-icon">🛋️</div>
        <div class="feature-title">Luxury Rooms</div>
        <div class="feature-desc">Elegan & Nyaman — setiap kamar dirancang untuk memberikan pengalaman menginap terbaik.</div>
    </div>
    <div class="feature-item">
        <div class="feature-icon">🏊</div>
        <div class="feature-title">Premium Facilities</div>
        <div class="feature-desc">Kolam Renang, Spa, Gym — fasilitas kelas dunia tersedia untuk seluruh tamu.</div>
    </div>
    <div class="feature-item">
        <div class="feature-icon">⭐</div>
        <div class="feature-title">Five-Star Service</div>
        <div class="feature-desc">Pelayanan 24 Jam — tim kami siap melayani Anda kapan saja dengan sepenuh hati.</div>
    </div>
</section>

<!-- ROOMS PREVIEW -->
<section class="rooms-section">
    <p style="font-size:11px;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:12px;">✦ Koleksi Kamar</p>
    <h2 class="section-title">Pilih Kamar Impian Anda</h2>
    <div class="gold-line"></div>
    <div class="rooms-grid">
        @foreach(App\Models\Kamar::where('status','!=','nonaktif')->take(3)->get() as $kamar)
        <div class="room-card">
            <div class="room-img">
                @if($kamar->foto)
                    <img src="{{ asset('uploads/kamar/' . $kamar->foto) }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    🛏️
                @endif
            </div>
            <div class="room-body">
                <div class="room-type">{{ $kamar->tipe_kamar }}</div>
                <div class="room-name">Kamar {{ $kamar->nomor_kamar }}</div>
                <div class="room-price">Rp {{ number_format($kamar->harga_per_malam,0,',','.') }} <span>/ malam</span></div>
                <a href="{{ route('kamar.index') }}" class="btn btn-gold">Mulai Booking</a>
            </div>
        </div>
        @endforeach
    </div>
    <div style="text-align:center;margin-top:48px;">
        <a href="{{ route('kamar.index', ['mode' => 'lihat']) }}" class="btn btn-outline">Lihat Kamar</a>
    </div>
</section>

@endsection