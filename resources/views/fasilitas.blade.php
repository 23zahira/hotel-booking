@extends('layouts.app')

@section('title', 'Fasilitas - Zanadisia Grand')

@section('content')

<div style="padding: 80px 40px; max-width: 1100px; margin: 0 auto;">

    <div class="section-title">Fasilitas Kami</div>
    <div class="gold-line"></div>
    <p class="section-subtitle">Nikmati berbagai fasilitas mewah yang kami sediakan untuk kenyamanan Anda</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">

        <div class="card" style="padding: 32px;">
            <div style="font-size: 40px; margin-bottom: 16px;">🏊</div>
            <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); margin-bottom: 10px;">Infinity Pool</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Kolam renang tanpa batas dengan pemandangan kota yang memukau. Tersedia 24 jam untuk tamu hotel.</p>
        </div>

        <div class="card" style="padding: 32px;">
            <div style="font-size: 40px; margin-bottom: 16px;">💆</div>
            <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); margin-bottom: 10px;">Spa & Wellness</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Pusat spa kelas dunia dengan terapis profesional. Tersedia berbagai pilihan perawatan tubuh dan relaksasi.</p>
        </div>

        <div class="card" style="padding: 32px;">
            <div style="font-size: 40px; margin-bottom: 16px;">🍽️</div>
            <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); margin-bottom: 10px;">Fine Dining Restaurant</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Restoran mewah dengan menu masakan internasional dan lokal yang disiapkan oleh chef berbintang.</p>
        </div>

        <div class="card" style="padding: 32px;">
            <div style="font-size: 40px; margin-bottom: 16px;">🏋️</div>
            <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); margin-bottom: 10px;">Fitness Center</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Pusat kebugaran modern dengan peralatan terkini. Personal trainer tersedia atas permintaan.</p>
        </div>

        <div class="card" style="padding: 32px;">
            <div style="font-size: 40px; margin-bottom: 16px;">🤝</div>
            <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); margin-bottom: 10px;">Meeting & Event Hall</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Ruang pertemuan eksklusif dengan kapasitas hingga 500 orang, dilengkapi teknologi audio visual terkini.</p>
        </div>

        <div class="card" style="padding: 32px;">
            <div style="font-size: 40px; margin-bottom: 16px;">🚗</div>
            <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); margin-bottom: 10px;">Valet Parking</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Layanan parkir valet 24 jam dengan keamanan terjamin. Area parkir luas untuk kendaraan tamu.</p>
        </div>

        <div class="card" style="padding: 32px;">
            <div style="font-size: 40px; margin-bottom: 16px;">🛎️</div>
            <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); margin-bottom: 10px;">Butler Service</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Layanan butler personal khusus tamu suite. Siap membantu segala kebutuhan Anda selama 24 jam.</p>
        </div>

        <div class="card" style="padding: 32px;">
            <div style="font-size: 40px; margin-bottom: 16px;">🌐</div>
            <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); margin-bottom: 10px;">High-Speed WiFi</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Koneksi internet ultra cepat tersedia di seluruh area hotel tanpa batas waktu dan kuota.</p>
        </div>

        <div class="card" style="padding: 32px;">
            <div style="font-size: 40px; margin-bottom: 16px;">✈️</div>
            <h3 style="font-family: 'Playfair Display', serif; color: var(--gold); margin-bottom: 10px;">Airport Transfer</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7;">Layanan antar jemput bandara dengan kendaraan mewah dan pengemudi profesional berpengalaman.</p>
        </div>

    </div>

    <div style="text-align: center; margin-top: 60px;">
        <a href="{{ route('kamar.index') }}" class="btn btn-gold">Pesan Kamar Sekarang</a>
    </div>

</div>

@endsection