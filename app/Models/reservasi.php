<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_kamar',
        'kode_pesanan',
        'tanggal_check_in',
        'tanggal_check_out',
        'total_malam',
        'total_harga',
        'status',
    ];

    // kamar yang dipesan dalam reservasi
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }

    // user yang melakukan reservasi
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function pembayaran()
    {
    return $this->hasOne(Pembayaran::class, 'kode_pesanan', 'kode_pesanan');
    }
}