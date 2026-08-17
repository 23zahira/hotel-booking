<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;

class NotifikasiController extends Controller
{
    public function count()
    {
        $jumlah = Reservasi::where('status', 'menunggu_konfirmasi_pembayaran')->count();

        return response()->json(['jumlah' => $jumlah]);
    }
}