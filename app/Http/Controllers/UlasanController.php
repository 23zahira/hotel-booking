<?php
namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function create($id_reservasi)
    {
        $reservasi = Reservasi::with('kamar')
            ->where('id_reservasi', $id_reservasi)
            ->where('id_user', auth()->user()->id_user)
            ->where('status', 'selesai')
            ->firstOrFail();

        return view('ulasan.create', compact('reservasi'));
    }

    public function index()
    {
        $ulasans = Ulasan::with('reservasi.kamar')
    ->where('id_user', auth()->user()->id_user)
    ->orderBy('id_ulasan', 'desc')
    ->get();

    return view('ulasan.index', compact('ulasans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_reservasi' => 'required',
            'rating'       => 'required|integer|min:1|max:5',
            'komentar'     => 'required'
        ]);

        $sudahAda = Ulasan::where('id_user', auth()->user()->id_user)
            ->where('id_reservasi', $request->id_reservasi)
            ->exists();

        if ($sudahAda) {
            return redirect()->route('reservasi.riwayat')
                ->with('error', 'Anda sudah memberikan ulasan untuk reservasi ini.');
        }

        $reservasi = Reservasi::findOrFail($request->id_reservasi);
    
    Ulasan::create([
    'id_user'      => auth()->user()->id_user,
    'id_reservasi' => $request->id_reservasi,
    'rating'       => $request->rating,
    'komentar'     => $request->komentar
]);

        return redirect()->route('reservasi.riwayat')
            ->with('success', 'Ulasan berhasil dikirim. Terima kasih!');
    }
}