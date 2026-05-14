<?php

namespace App\Http\Controllers;

use App\Models\Buku; // Panggil model Buku
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
{
    // Mengambil input cari dari URL
    $cari = $request->query('cari');

    // Jika ada input cari, filter data buku. Jika tidak, ambil semua.
    $semuaBuku = \App\Models\Buku::when($cari, function($query, $cari) {
        return $query->where('judul', 'like', "%{$cari}%")
                     ->orWhere('penulis', 'like', "%{$cari}%");
    })->get();

    return view('daftar_buku', compact('semuaBuku'));
}

    // Menghapus Buku
public function destroy($id)
{
    $buku = \App\Models\Buku::findOrFail($id);
    $buku->delete();
    return back()->with('success', 'Buku berhasil dihapus!');
}

// Menampilkan Form Tambah Buku
public function create()
{
    return view('admin.buku.tambah');
}

// Menyimpan Buku Baru
public function store(Request $request)
{
    $request->validate([
        'judul' => 'required',
        'penulis' => 'required',
        'penerbit' => 'required',
        'tahun_terbit' => 'required|numeric',
        'stok' => 'required|numeric',
        'gambar' => 'image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $namaFile = null;
    if ($request->hasFile('gambar')) {
        $namaFile = time().'.'.$request->gambar->extension();
        $request->gambar->move(public_path('img'), $namaFile);
    }

    \App\Models\Buku::create([
        'judul' => $request->judul,
        'penulis' => $request->penulis,
        'penerbit' => $request->penerbit,
        'tahun_terbit' => $request->tahun_terbit,
        'stok' => $request->stok,
        'gambar' => $namaFile,
    ]);

    return redirect('/katalog-admin')->with('success', 'Buku berhasil ditambahkan!');
}

public function edit($id)
{
    $buku = \App\Models\Buku::findOrFail($id);
    return view('admin.buku.edit', compact('buku'));
}

public function update(Request $request, $id)
{
    $buku = \App\Models\Buku::findOrFail($id);
    $data = $request->all();
    
    if ($request->hasFile('gambar')) {
        $namaFile = time().'.'.$request->gambar->extension();
        $request->gambar->move(public_path('img'), $namaFile);
        $data['gambar'] = $namaFile;
    }

    $buku->update($data);
    return redirect('/katalog-admin')->with('success', 'Buku berhasil diupdate!');
}

}