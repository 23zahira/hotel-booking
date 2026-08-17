<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';
    public $timestamps = false;

    protected $fillable = [
    'id_user',
    'id_reservasi',
    'rating',
    'komentar',
];

    // user yang memberi ulasan
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // ulasan berasal dari reservasi
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id_reservasi');
    }
}