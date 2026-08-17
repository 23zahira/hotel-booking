<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Notification;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with(['user', 'kamar', 'pembayaran'])->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $reservasis = $query->paginate(10);
        return view('admin.reservasi.index', compact('reservasis'));
    }

    public function show($id)
    {
        $reservasi = Reservasi::with(['user', 'kamar', 'pembayaran'])->findOrFail($id);
        return view('admin.reservasi.show', compact('reservasi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $reservasi = Reservasi::with('kamar')->findOrFail($id);
        $reservasi->update(['status' => $request->status]);

        $namaKamar = $reservasi->kamar->nama ?? '-';

        // Kirim notifikasi ke user sesuai status baru
        if ($request->status === 'dikonfirmasi') {
            Notification::create([
                'id_user' => $reservasi->id_user,
                'judul'   => 'Reservasi Dikonfirmasi',
                'pesan'   => 'Reservasi kamu untuk kamar ' . $namaKamar . ' telah dikonfirmasi oleh admin.',
                'status'  => 'belum_dibaca',
            ]);
        } elseif ($request->status === 'dibatalkan') {
            Notification::create([
                'id_user' => $reservasi->id_user,
                'judul'   => 'Reservasi Dibatalkan',
                'pesan'   => 'Mohon maaf, reservasi kamu untuk kamar ' . $namaKamar . ' dibatalkan oleh admin.',
                'status'  => 'belum_dibaca',
            ]);
        } elseif ($request->status === 'selesai') {
            Notification::create([
                'id_user' => $reservasi->id_user,
                'judul'   => 'Reservasi Selesai',
                'pesan'   => 'Terima kasih telah menginap. Reservasi kamu untuk kamar ' . $namaKamar . ' telah selesai.',
                'status'  => 'belum_dibaca',
            ]);
        }

        return back()->with('success', 'Status reservasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Reservasi::findOrFail($id)->delete();
        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil dihapus.');
    }
}