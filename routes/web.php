<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;

// --- HALAMAN UMUM ---
Route::get('/', function () { return view('welcome'); });

// --- AUTHENTICATION ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// --- HALAMAN PEMINJAM (USER BIASA) ---
Route::middleware('auth')->group(function () {
    Route::get('/katalog', [BukuController::class, 'index']);
    Route::get('/buku', [BukuController::class, 'index']);
});

// --- HALAMAN DASHBOARD & ADMIN (SIDEBAR) ---
Route::middleware('auth')->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', function () {
        if (Auth::user()->role == 'peminjam') {
            return redirect('/katalog');
        }
        return view('admin.dashboard', [
            'jumlahBuku' => Buku::count(),
            'jumlahUser' => User::count(),
            'jumlahPinjam' => \App\Models\Peminjaman::count(),
        ]);
    });

    // Manajemen Buku (Admin)
    Route::get('/katalog-admin', function (Request $request) {
        $cari = $request->cari;
        $semuaBuku = Buku::when($cari, function ($query) use ($cari) {
            return $query->where('judul', 'like', "%$cari%")
                         ->orWhere('penulis', 'like', "%$cari%");
        })->get();
        return view('admin.buku.index', compact('semuaBuku'));
    });

    Route::get('/buku/tambah', [BukuController::class, 'create']);
    Route::post('/buku', [BukuController::class, 'store']);
    Route::get('/buku/edit/{id}', [BukuController::class, 'edit']);
    Route::put('/buku/{id}', [BukuController::class, 'update']);
    Route::delete('/buku/{id}', [BukuController::class, 'destroy']);

    // Manajemen Users (Admin)
    Route::get('/users', function () {
        $semuaUser = User::all();
        return view('admin.users.index', compact('semuaUser'));
    });
    
    Route::get('/users/tambah', function() {
        return view('admin.users.tambah');
    });

    Route::post('/users/simpan', [AuthController::class, 'storeUser'])->middleware('auth');
    Route::get('/users/edit/{id}', [AuthController::class, 'editUser'])->middleware('auth');
    Route::put('/users/{id}', [AuthController::class, 'updateUser'])->middleware('auth');
    Route::delete('/users/{id}', [AuthController::class, 'destroyUser']);

    // Menampilkan Form Tambah
Route::get('/peminjaman/tambah', function () {
    return view('admin.peminjaman.tambah', [
        'users' => \App\Models\User::all(),
        'bukus' => \App\Models\Buku::all()
    ]);
})->middleware('auth');

// Proses Simpan Transaksi
Route::post('/peminjaman/simpan', function (Illuminate\Http\Request $request) {
    \App\Models\Peminjaman::create([
        'user_id' => $request->user_id,
        'buku_id' => $request->buku_id,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'tanggal_kembali' => $request->tanggal_kembali,
        'status' => 'dipinjam' // Otomatis berstatus dipinjam
    ]);
    return redirect('/peminjaman')->with('success', 'Transaksi berhasil dicatat!');
})->middleware('auth');

    // Transaksi Peminjaman & Pengembalian
    Route::get('/peminjaman', function () {
        $semuaPeminjaman = \App\Models\Peminjaman::with(['user', 'buku'])->get();
        return view('admin.peminjaman.index', compact('semuaPeminjaman'));
    });

    Route::get('/pengembalian', function () {
        return view('admin.pengembalian.index'); 
    });

    Route::get('/laporan', function () {
        return view('admin.laporan.index');
    });
});