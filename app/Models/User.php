<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama', 'email', 'password', 'no_telepon', 'role'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_user');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_user');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_user')->latest();
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('status', 'belum_dibaca');
    }
}