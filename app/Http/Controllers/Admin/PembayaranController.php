<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\Notification;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::latest('tanggal_bayar')->paginate(10);

        // lampirkan daftar reservasi (kamar + user) untuk tiap kode_pesanan
        $pembayarans->getCollection()->transform(function ($pembayaran) {
            $pembayaran->reservasiList = Reservasi::with(['user', 'kamar'])
                ->where('kode_pesanan', $pembayaran->kode_pesanan)
                ->get();
            return $pembayaran;
        });

        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $reservasiList = Reservasi::with(['user', 'kamar'])
            ->where('kode_pesanan', $pembayaran->kode_pesanan)
            ->get();

        return view('admin.pembayaran.show', compact('pembayaran', 'reservasiList'));
    }

    public function konfirmasi($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update(['status_bayar' => 'valid']);

        $reservasiList = Reservasi::with('kamar')
            ->where('kode_pesanan', $pembayaran->kode_pesanan)
            ->get();

        foreach ($reservasiList as $reservasi) {
            $reservasi->update(['status' => 'dikonfirmasi']);

            Notification::create([
                'id_user' => $reservasi->id_user,
                'judul'   => 'Reservasi Dikonfirmasi',
                'pesan'   => 'Reservasi kamu untuk kamar ' . ($reservasi->kamar->tipe_kamar ?? '-') . ' telah dikonfirmasi oleh admin.',
                'status'  => 'belum_dibaca',
            ]);
        }

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function tolak($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update(['status_bayar' => 'ditolak']);

        $reservasiList = Reservasi::with('kamar')
            ->where('kode_pesanan', $pembayaran->kode_pesanan)
            ->get();

        foreach ($reservasiList as $reservasi) {
            $reservasi->update(['status' => 'dibatalkan']);

            Notification::create([
                'id_user' => $reservasi->id_user,
                'judul'   => 'Reservasi Dibatalkan',
                'pesan'   => 'Mohon maaf, pembayaran untuk kamar ' . ($reservasi->kamar->tipe_kamar ?? '-') . ' ditolak oleh admin.',
                'status'  => 'belum_dibaca',
            ]);
        }

        return back()->with('success', 'Pembayaran berhasil ditolak.');
    }

    public function destroy($id)
    {
        Pembayaran::findOrFail($id)->delete();
        return redirect()->route('admin.pembayaran.index')->with('success', 'Data pembayaran berhasil dihapus.');
    }
}