<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
   public function lihat()
{
    $kamars = Kamar::orderBy('nomor_kamar')->get()->map(function ($kamar) {
        $kamar->tersedia = $kamar->status === 'tersedia';
        return $kamar;
    });

    return view('kamar.lihat', compact('kamars'));
}
  public function index()
{
    $kamars = Kamar::orderBy('nomor_kamar')->paginate(10);

    return view('admin.kamar.index', compact('kamars'));
}
    public function create()
    {
        return view('admin.kamar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar'     => 'required|unique:kamar,nomor_kamar',
            'tipe_kamar'      => 'required',
            'harga_per_malam' => 'required|numeric',
            'fasilitas'       => 'nullable|string',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status'          => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/kamar'), $filename);
            $data['foto'] = $filename;
        }

        Kamar::create($data);

        return redirect()
            ->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        return view('admin.kamar.edit', compact('kamar'));
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);

        $request->validate([
            'nomor_kamar'     => 'required|unique:kamar,nomor_kamar,' . $id . ',id_kamar',
            'tipe_kamar'      => 'required',
            'harga_per_malam' => 'required|numeric',
            'status'          => 'required',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/kamar'), $filename);
            $data['foto'] = $filename;
        }

        $kamar->update($data);

        return redirect()
            ->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kamar::findOrFail($id)->delete();

        return redirect()
            ->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil dihapus.');
    }
}