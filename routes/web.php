<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\KamarController as AdminKamarController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\UlasanController as AdminUlasanController;
use App\Http\Controllers\Admin\NotifikasiController;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/fasilitas', function () { return view('fasilitas'); })->name('fasilitas');
Route::get('/tentang', function () { return view('tentang'); })->name('tentang');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamar/{id}', [KamarController::class, 'show'])->name('kamar.show');

    Route::post('/reservasi/pilih', [ReservasiController::class, 'pilihKamar'])
        ->name('reservasi.pilih');

    Route::get('/reservasi/konfirmasi', [ReservasiController::class, 'konfirmasi'])
        ->name('reservasi.konfirmasi');

    Route::post('/reservasi', [ReservasiController::class, 'store'])
        ->name('reservasi.store');

    Route::get('/reservasi/riwayat', [ReservasiController::class, 'riwayat'])
        ->name('reservasi.riwayat');

    Route::get('/reservasi/{id}', [ReservasiController::class, 'show'])
        ->name('reservasi.show');

    Route::post('/reservasi/{id}/batal', [ReservasiController::class, 'batal'])
        ->name('reservasi.batal');

    Route::get('/pembayaran/{kode_pesanan}/show', [PembayaranController::class, 'show'])
        ->name('pembayaran.show');

    Route::get('/pembayaran/{kode_pesanan}', [PembayaranController::class, 'create'])
        ->name('pembayaran.create');

    Route::post('/pembayaran/{kode_pesanan}', [PembayaranController::class, 'store'])
        ->name('pembayaran.store');
    
    Route::get('/pembayaran/{kode_pesanan}/bayar', [PembayaranController::class, 'bayar'])
    ->name('pembayaran.bayar');
    
    Route::post('/pembayaran/{kode_pesanan}/konfirmasi-bayar', [PembayaranController::class, 'konfirmasiBayar'])
    ->name('pembayaran.konfirmasiBayar');

    Route::get('/ulasan/buat/{id_reservasi}', [UlasanController::class, 'create'])
        ->name('ulasan.create');

    Route::post('/ulasan', [UlasanController::class, 'store'])
        ->name('ulasan.store');

    Route::get('/ulasan/saya', [UlasanController::class, 'index'])
        ->name('ulasan.index');

    // Notifikasi User
    Route::get('/notifikasi/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifikasi.read');

    Route::post('/notifikasi/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifikasi.readAll');
});


Route::middleware([
    'auth',
    \App\Http\Middleware\AdminMiddleware::class
])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Notifikasi
    Route::get('/notifikasi/count', [NotifikasiController::class, 'count'])->name('notifikasi.count');

    // Reservasi
    Route::get('/reservasi', [AdminReservasiController::class, 'index'])->name('reservasi.index');
    Route::get('/reservasi/{id}', [AdminReservasiController::class, 'show'])->name('reservasi.show');
    Route::post('/reservasi/{id}/status', [AdminReservasiController::class, 'updateStatus'])->name('reservasi.status');
    Route::delete('/reservasi/{id}', [AdminReservasiController::class, 'destroy'])->name('reservasi.destroy');

    // Pembayaran
    Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/{id}', [AdminPembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{id}/konfirmasi', [AdminPembayaranController::class, 'konfirmasi'])->name('pembayaran.konfirmasi');
    Route::post('/pembayaran/{id}/tolak', [AdminPembayaranController::class, 'tolak'])->name('pembayaran.tolak');
    Route::delete('/pembayaran/{id}', [AdminPembayaranController::class, 'destroy'])->name('pembayaran.destroy');
 
    // Kamar
    Route::get('/kamar', [AdminKamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamar/tambah', [AdminKamarController::class, 'create'])->name('kamar.create');
    Route::post('/kamar', [AdminKamarController::class, 'store'])->name('kamar.store');
    Route::get('/kamar/lihat', [KamarController::class, 'lihat'])->name('kamar.lihat');
    Route::get('/kamar/{id}/edit', [AdminKamarController::class, 'edit'])->name('kamar.edit');
    Route::put('/kamar/{id}', [AdminKamarController::class, 'update'])->name('kamar.update');
    Route::delete('/kamar/{id}', [AdminKamarController::class, 'destroy'])->name('kamar.destroy');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Ulasan
    Route::get('/ulasan', [AdminUlasanController::class, 'index'])->name('ulasan.index');
    Route::delete('/ulasan/{id}', [AdminUlasanController::class, 'destroy'])->name('ulasan.destroy');
});