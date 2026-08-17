<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\User;
use App\Models\Kamar;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalReservasi    = Reservasi::count();
        $menungguKonfirmasi = Reservasi::where('status', 'menunggu_konfirmasi_pembayaran')->count();
        $dikonfirmasi      = Reservasi::where('status', 'dikonfirmasi')->count();
        $selesai           = Reservasi::where('status', 'selesai')->count();

        $reservasiTerbaru = Reservasi::with(['user', 'kamar'])
            ->latest()->take(5)->get();

        $reservasi7Hari = Reservasi::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('admin.dashboard', compact(
            'totalReservasi', 'menungguKonfirmasi',
            'dikonfirmasi', 'selesai',
            'reservasiTerbaru', 'reservasi7Hari'
        ));
    }
}