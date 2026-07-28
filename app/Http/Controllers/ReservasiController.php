<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Reservasi;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    // Tahap 3 — simpan kamar yang dicentang ke session
    public function pilihKamar(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required|array|min:1',
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
        ]);

        $kodePesanan = 'RSV-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

        session([
            'kode_pesanan' => $kodePesanan,
            'kamar_terpilih' => $request->id_kamar,
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
        ]);

        return redirect()->route('reservasi.konfirmasi');
    }

    // Tahap 4 — tampilkan ringkasan gabungan dari session
    public function konfirmasi()
    {
        if (!session()->has('kamar_terpilih')) {
            return redirect()->route('kamar.index')
                ->with('error', 'Silakan pilih kamar terlebih dahulu.');
        }

        $kamarList = Kamar::whereIn('id_kamar', session('kamar_terpilih'))->get();

        $checkin = Carbon::parse(session('checkin'));
        $checkout = Carbon::parse(session('checkout'));
        $totalMalam = $checkin->diffInDays($checkout);

        $subtotal = 0;
        foreach ($kamarList as $kamar) {
            $subtotal += $kamar->harga_per_malam * $totalMalam;
        }
        $pajak = $subtotal * 0.1;
        $totalKeseluruhan = $subtotal + $pajak;

        return view('reservasi.konfirmasi', [
            'kamarList' => $kamarList,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'totalMalam' => $totalMalam,
            'subtotal' => $subtotal,
            'pajak' => $pajak,
            'totalKeseluruhan' => $totalKeseluruhan,
            'kodePesanan' => session('kode_pesanan'),
        ]);
    }

    // Tahap 5 — insert banyak baris reservasi sekaligus, satu kode_pesanan
    public function store(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required|array|min:1',
            'kode_pesanan' => 'required|string',
            'tanggal_check_in' => 'required|date',
            'tanggal_check_out' => 'required|date|after:tanggal_check_in',
        ]);

        $checkin = Carbon::parse($request->tanggal_check_in);
        $checkout = Carbon::parse($request->tanggal_check_out);
        $malam = $checkin->diffInDays($checkout);

        $kamarList = Kamar::whereIn('id_kamar', $request->id_kamar)->get();

        foreach ($kamarList as $kamar) {
            Reservasi::create([
                'id_user' => auth()->user()->id_user,
                'id_kamar' => $kamar->id_kamar,
                'kode_pesanan' => $request->kode_pesanan,
                'tanggal_check_in' => $request->tanggal_check_in,
                'tanggal_check_out' => $request->tanggal_check_out,
                'total_malam' => $malam,
                'total_harga' => $kamar->harga_per_malam * $malam,
                'status' => 'menunggu',
            ]);
        }

        // Bersihkan session "keranjang" setelah tersimpan
        session()->forget(['kode_pesanan', 'kamar_terpilih', 'checkin', 'checkout']);

        return redirect()->route('pembayaran.create', $request->kode_pesanan);
    }

    public function riwayat()
    {
        $reservasi = Reservasi::where('id_user', auth()->user()->id_user)
            ->with(['kamar', 'pembayaran'])
            ->latest()
            ->get();

        return view('reservasi.riwayat', compact('reservasi'));
    }

    public function show($id)
    {
        $reservasi = Reservasi::with(['kamar', 'pembayaran'])
            ->where('id_user', auth()->user()->id_user)
            ->findOrFail($id);

        return view('reservasi.show', compact('reservasi'));
    }

    public function batal($id)
    {
        $reservasi = Reservasi::where('id_user', auth()->user()->id_user)
            ->findOrFail($id);

        if ($reservasi->status === 'menunggu') {
            $reservasi->update(['status' => 'dibatalkan']);

            return back()->with('success', 'Reservasi berhasil dibatalkan.');
        }

        return back()->with('error', 'Reservasi tidak dapat dibatalkan.');
    }
}