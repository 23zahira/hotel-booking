<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;

class UlasanController extends Controller
{
    public function index()
{
    $ulasans = Ulasan::with(['user', 'reservasi.kamar'])
    ->orderBy('id_ulasan', 'desc')
    ->paginate(10);

    return view('admin.ulasan.index', compact('ulasans'));
}

    public function destroy($id)
    {
        Ulasan::findOrFail($id)->delete();
        return redirect()->route('admin.ulasan.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}