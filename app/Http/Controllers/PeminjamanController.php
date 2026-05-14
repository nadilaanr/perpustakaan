<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman; // Panggil model Peminjaman
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Fungsi ini nantinya untuk menampilkan riwayat peminjaman
        return "Ini adalah halaman riwayat peminjaman buku.";
    }

    public function store(Request $request)
    {
        // Fungsi ini nantinya tempat kamu menaruh logika:
        // 1. Cek apakah user sudah pinjam 2 buku?
        // 2. Simpan data reservasi ke database.
        // 3. Set waktu batas_ambil (tgl_reservasi + 2 jam).
    }
}