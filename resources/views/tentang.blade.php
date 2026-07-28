@extends('layouts.app')

@section('title', 'Tentang Kami - ZANADISIA GRAND')

@section('content')

<div style="padding: 80px 40px; max-width: 1100px; margin: 0 auto;">

    {{-- Hero Section --}}
    <div style="text-align: center; margin-bottom: 80px;">
        <div style="font-family: 'Playfair Display', serif; font-size: 48px; color: var(--gold); margin-bottom: 16px;">⬡ ZANADISIA Grand</div>
        <p style="color: var(--text-muted); font-size: 16px; letter-spacing: 2px; text-transform: uppercase;">Experience Pure Luxury</p>
        <div class="gold-line" style="margin: 20px auto;"></div>
        <p style="color: var(--text-muted); max-width: 700px; margin: 0 auto; font-size: 15px; line-height: 1.8;">
            Zanadisia Grand Hotel adalah destinasi kemewahan terdepan yang menghadirkan pengalaman menginap tak tertandingi. Sejak berdiri, kami berkomitmen untuk memberikan pelayanan terbaik kepada setiap tamu yang mempercayakan momen berharga mereka kepada kami.
        </p>
    </div>

    {{-- Statistik --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 80px;">
        <div class="card" style="padding: 32px; text-align: center;">
            <div style="font-family: 'Playfair Display', serif; font-size: 48px; color: var(--gold);">15+</div>
            <p style="color: var(--text-muted); font-size: 13px; letter-spacing: 1px; text-transform: uppercase; margin-top: 8px;">Tahun Berpengalaman</p>
        </div>
        <div class="card" style="padding: 32px; text-align: center;">
            <div style="font-family: 'Playfair Display', serif; font-size: 48px; color: var(--gold);">50+</div>
            <p style="color: var(--text-muted); font-size: 13px; letter-spacing: 1px; text-transform: uppercase; margin-top: 8px;">Kamar Mewah</p>
        </div>
        <div class="card" style="padding: 32px; text-align: center;">
            <div style="font-family: 'Playfair Display', serif; font-size: 48px; color: var(--gold);">10K+</div>
            <p style="color: var(--text-muted); font-size: 13px; letter-spacing: 1px; text-transform: uppercase; margin-top: 8px;">Tamu Puas</p>
        </div>
        <div class="card" style="padding: 32px; text-align: center;">
            <div style="font-family: 'Playfair Display', serif; font-size: 48px; color: var(--gold);">5★</div>
            <p style="color: var(--text-muted); font-size: 13px; letter-spacing: 1px; text-transform: uppercase; margin-top: 8px;">Rating Hotel</p>
        </div>
    </div>

    {{-- Visi Misi --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 80px;">
        <div class="card" style="padding: 40px;">
            <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); font-size: 24px; margin-bottom: 16px;">Visi Kami</h3>
            <div class="gold-line"></div>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.8;">
                Menjadi hotel bintang lima terkemuka yang dikenal secara internasional sebagai simbol kemewahan, keanggunan, dan pelayanan prima yang tak tertandingi di Asia Tenggara.
            </p>
        </div>
        <div class="card" style="padding: 40px;">
            <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); font-size: 24px; margin-bottom: 16px;">Misi Kami</h3>
            <div class="gold-line"></div>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.8;">
                Menghadirkan pengalaman menginap yang tak terlupakan melalui fasilitas mewah, pelayanan personal yang hangat, dan perhatian penuh terhadap setiap detail kebutuhan tamu kami.
            </p>
        </div>
    </div>

    {{-- Nilai --}}
    <div style="margin-bottom: 80px;">
        <div class="section-title" style="text-align: center;">Nilai-Nilai Kami</div>
        <div class="gold-line" style="margin: 12px auto 40px;"></div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
            <div style="text-align: center; padding: 24px;">
                <div style="font-size: 36px; margin-bottom: 16px;">👑</div>
                <h4 style="color: var(--gold); margin-bottom: 10px; font-family: 'Playfair Display', serif;">Kemewahan</h4>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Setiap sudut hotel dirancang untuk memberikan pengalaman kemewahan yang autentik.</p>
            </div>
            <div style="text-align: center; padding: 24px;">
                <div style="font-size: 36px; margin-bottom: 16px;">🤍</div>
                <h4 style="color: var(--gold); margin-bottom: 10px; font-family: 'Playfair Display', serif;">Ketulusan</h4>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Melayani setiap tamu dengan sepenuh hati dan ketulusan yang tulus dari seluruh tim kami.</p>
            </div>
            <div style="text-align: center; padding: 24px;">
                <div style="font-size: 36px; margin-bottom: 16px;">✨</div>
                <h4 style="color: var(--gold); margin-bottom: 10px; font-family: 'Playfair Display', serif;">Keunggulan</h4>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Standar pelayanan tertinggi yang selalu kami jaga demi kepuasan dan kenyamanan tamu.</p>
            </div>
        </div>
    </div>

    {{-- Kontak --}}
    <div class="card" style="padding: 40px; text-align: center;">
        <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); font-size: 28px; margin-bottom: 24px;">Hubungi Kami</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; color: var(--text-muted); font-size: 14px;">
            <div>
                <div style="font-size: 24px; margin-bottom: 8px;">📍</div>
                <p>Jl. Kemewahan No. 1<br>Jakarta Pusat, Indonesia</p>
            </div>
            <div>
                <div style="font-size: 24px; margin-bottom: 8px;">📞</div>
                <p>+62 21 1234 5678<br>+62 812 3456 7890</p>
            </div>
            <div>
                <div style="font-size: 24px; margin-bottom: 8px;">✉️</div>
                <p>info@zanadisiagrand.com<br>reservation@zanadisiagrand.com</p>
            </div>
            <div>
                <div style="font-size: 24px; margin-bottom: 8px;">🕐</div>
                <p>Check-in: 14.00 WIB<br>Check-out: 12.00 WIB</p>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 60px;">
        <a href="{{ route('kamar.index') }}" class="btn btn-gold">Pesan Kamar Sekarang</a>
    </div>

</div>

@endsection