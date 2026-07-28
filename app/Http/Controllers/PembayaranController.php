<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Tampilkan form pembayaran untuk satu kode_pesanan (pilihan metode)
     */
    public function create($kode_pesanan)
    {
        $reservasiList = Reservasi::with('kamar')
            ->where('id_user', auth()->user()->id_user)
            ->where('kode_pesanan', $kode_pesanan)
            ->get();

        if ($reservasiList->isEmpty()) {
            abort(404, 'Reservasi tidak ditemukan.');
        }

        $sudahBayar = Pembayaran::where('kode_pesanan', $kode_pesanan)->first();
        if ($sudahBayar) {
            return redirect()->route('pembayaran.show', $kode_pesanan);
        }

        $totalBayar = $reservasiList->sum('total_harga');

        return view('pembayaran.create', compact('reservasiList', 'kode_pesanan', 'totalBayar'));
    }

    /**
     * Simpan bukti pembayaran (khusus metode Transfer Bank manual)
     */
    public function store(Request $request, $kode_pesanan)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'metode_bayar'   => 'required|string',
        ]);

        $reservasiList = Reservasi::where('id_user', auth()->user()->id_user)
            ->where('kode_pesanan', $kode_pesanan)
            ->get();

        if ($reservasiList->isEmpty()) {
            abort(404, 'Reservasi tidak ditemukan.');
        }

        $sudahBayar = Pembayaran::where('kode_pesanan', $kode_pesanan)->first();
        if ($sudahBayar) {
            return redirect()->route('pembayaran.show', $kode_pesanan)
                ->with('success', 'Pembayaran untuk pesanan ini sudah pernah dikirim.');
        }

        $totalBayar = $reservasiList->sum('total_harga');

        $file = $request->file('bukti_transfer');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti'), $filename);

        Pembayaran::create([
            'id_reservasi'   => $reservasiList->first()->id_reservasi,
            'kode_pesanan'   => $kode_pesanan,
            'jumlah_bayar'   => $totalBayar,
            'metode_bayar'   => $request->metode_bayar,
            'bukti_transfer' => $filename,
            'status_bayar'   => 'menunggu',
            'tanggal_bayar'  => now(),
        ]);

        Reservasi::where('kode_pesanan', $kode_pesanan)
            ->update(['status' => 'menunggu_konfirmasi_pembayaran']);

        return redirect()->route('reservasi.riwayat')
            ->with('success', 'Bukti transfer berhasil dikirim.');
    }

    /**
     * Halaman "link pembayaran" - pilih Virtual Account atau QRIS
     */
    public function bayar($kode_pesanan)
    {
        $reservasiList = Reservasi::with('kamar')
            ->where('id_user', auth()->user()->id_user)
            ->where('kode_pesanan', $kode_pesanan)
            ->get();

        if ($reservasiList->isEmpty()) {
            abort(404, 'Reservasi tidak ditemukan.');
        }

        $sudahBayar = Pembayaran::where('kode_pesanan', $kode_pesanan)->first();
        if ($sudahBayar) {
            return redirect()->route('pembayaran.show', $kode_pesanan);
        }

        $totalBayar = $reservasiList->sum('total_harga');

        // generate nomor VA dummy yang konsisten untuk kode_pesanan ini
        $nomorVA = '8808' . substr(md5($kode_pesanan), 0, 12);

        return view('pembayaran.bayar', compact('reservasiList', 'kode_pesanan', 'totalBayar', 'nomorVA'));
    }

    /**
     * Konfirmasi pembayaran instan untuk Virtual Account / QRIS (simulasi)
     */
    public function konfirmasiBayar(Request $request, $kode_pesanan)
    {
        $request->validate([
            'metode_bayar' => 'required|string',
        ]);

        $reservasiList = Reservasi::where('id_user', auth()->user()->id_user)
            ->where('kode_pesanan', $kode_pesanan)
            ->get();

        if ($reservasiList->isEmpty()) {
            abort(404, 'Reservasi tidak ditemukan.');
        }

        $sudahBayar = Pembayaran::where('kode_pesanan', $kode_pesanan)->first();
        if ($sudahBayar) {
            return redirect()->route('pembayaran.show', $kode_pesanan);
        }

        $totalBayar = $reservasiList->sum('total_harga');

        Pembayaran::create([
            'id_reservasi'   => $reservasiList->first()->id_reservasi,
            'kode_pesanan'   => $kode_pesanan,
            'jumlah_bayar'   => $totalBayar,
            'metode_bayar'   => $request->metode_bayar,
            'bukti_transfer' => null,
            'status_bayar'   => 'valid',
            'tanggal_bayar'  => now(),
        ]);

        Reservasi::where('kode_pesanan', $kode_pesanan)
            ->update(['status' => 'dikonfirmasi']);

        return redirect()->route('pembayaran.show', $kode_pesanan)
            ->with('success', 'Pembayaran berhasil dikonfirmasi otomatis.');
    }

    /**
     * Tampilkan detail pembayaran berdasarkan kode_pesanan
     */
    public function show($kode_pesanan)
    {
        $pembayaran = Pembayaran::where('kode_pesanan', $kode_pesanan)
            ->firstOrFail();

        $reservasiList = Reservasi::with('kamar')
            ->where('kode_pesanan', $kode_pesanan)
            ->where('id_user', auth()->user()->id_user)
            ->get();

        if ($reservasiList->isEmpty()) {
            abort(404, 'Reservasi tidak ditemukan.');
        }

        return view('pembayaran.show', compact('pembayaran', 'reservasiList'));
    }
}