<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false;

    protected $fillable = [
    'id_reservasi',
    'kode_pesanan',
    'jumlah_bayar',
    'metode_bayar',
    'bukti_transfer',
    'status_bayar',
    'tanggal_bayar',
    ];
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id_reservasi');
    }
}