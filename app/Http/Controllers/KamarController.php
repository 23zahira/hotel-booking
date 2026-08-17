<?php
namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $checkin  = $request->checkin;
        $checkout = $request->checkout;
        $malam    = $request->malam ?? 1;
        $mode     = $request->query('mode', 'booking'); // 'booking' atau 'lihat'
        $kamars   = Kamar::orderBy('nomor_kamar')->get();

        if ($checkin && $checkout) {
            $kamars = $kamars->map(function ($kamar) use ($checkin, $checkout) {
                $bentrok = Reservasi::where('id_kamar', $kamar->id_kamar)
                    ->whereIn('status', ['menunggu', 'dikonfirmasi'])
                    ->where(function ($q) use ($checkin, $checkout) {
                        $q->whereBetween('tanggal_check_in', [$checkin, $checkout])
                          ->orWhereBetween('tanggal_check_out', [$checkin, $checkout])
                          ->orWhere(function ($q2) use ($checkin, $checkout) {
                              $q2->where('tanggal_check_in', '<=', $checkin)
                                 ->where('tanggal_check_out', '>=', $checkout);
                          });
                    })->exists();

                $kamar->tersedia = !$bentrok;
                return $kamar;
            });
        } else {
            $kamars = $kamars->map(function ($kamar) {
                $kamar->tersedia = $kamar->status === 'tersedia';
                return $kamar;
            });
        }

        return view('kamar.index', compact('kamars', 'checkin', 'checkout', 'malam', 'mode'));
    }

    public function show($id)
    {
        $kamar  = Kamar::findOrFail($id);
        $ulasan = $kamar->ulasan()->with('user')->latest()->get();
        return view('kamar.show', compact('kamar', 'ulasan'));
    }
} 