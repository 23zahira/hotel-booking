<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';
    protected $primaryKey = 'id_kamar';
    public $timestamps = false;

    protected $fillable = [
        'nomor_kamar', 'tipe_kamar', 'harga_per_malam',
        'fasilitas', 'foto', 'status'
    ];

   public function konfirmasi()
{
    if (!session()->has('kamar_terpilih')) {
        return redirect()->route('kamar.index')->with('error', 'Silakan pilih kamar terlebih dahulu.');
    }

    $kamarList = Kamar::whereIn('id_kamar', session('kamar_terpilih'))->get();

    $checkin = \Carbon\Carbon::parse(session('checkin'));
    $checkout = \Carbon\Carbon::parse(session('checkout'));
    $totalMalam = $checkin->diffInDays($checkout);

    $totalKeseluruhan = 0;
    foreach ($kamarList as $kamar) {
        $totalKeseluruhan += $kamar->harga_per_malam * $totalMalam;
    }

    return view('reservasi.konfirmasi', [
        'kamarList' => $kamarList,
        'checkin' => $checkin,
        'checkout' => $checkout,
        'totalMalam' => $totalMalam,
        'totalKeseluruhan' => $totalKeseluruhan,
        'kodePesanan' => session('kode_pesanan'),
    ]);
}

    public function getRatingRataRata()
    {
        return $this->ulasan()->avg('rating') ?? 0;
    }
}