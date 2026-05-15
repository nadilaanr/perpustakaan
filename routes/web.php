<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    
    // 1. DASHBOARD UTAMA
    Route::get('/dashboard', function () {
        if (Auth::user()->role == 'peminjam') {
            return redirect('/katalog');
        }

        // --- LOGIKA OTOMATIS BATALKAN RESERVASI ---
        // Cari reservasi yang sudah lewat 2 jam dari sekarang
        $expired = Peminjaman::where('status', 'reservasi')
                    ->where('batas_ambil', '<', now())
                    ->get();

        foreach($expired as $e) {
            // 1. Balikin stok buku karena tidak jadi diambil
            Buku::where('id', $e->buku_id)->increment('stok', 1);
            
            // 2. Ubah status data tersebut jadi 'batal'
            $e->update(['status' => 'batal']);
        }
        // --- SELESAI LOGIKA ---

        return view('admin.dashboard', [
            'jumlahBuku'   => Buku::count(),
            'jumlahUser'   => User::count(),
            'jumlahPinjam' => Peminjaman::where('status', 'dipinjam')->count(),
        ]);
    });

    // 2. MANAJEMEN BUKU
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

    // 3. MANAJEMEN USERS
    Route::get('/users', function () {
        $semuaUser = User::all();
        return view('admin.users.index', compact('semuaUser'));
    });
    Route::get('/users/tambah', function() { return view('admin.users.tambah'); });
    Route::post('/users/simpan', [AuthController::class, 'storeUser']);
    Route::get('/users/edit/{id}', [AuthController::class, 'editUser']);
    Route::put('/users/{id}', [AuthController::class, 'updateUser']);
    Route::delete('/users/{id}', [AuthController::class, 'destroyUser']);

    // 4. TRANSAKSI PEMINJAMAN
    Route::get('/peminjaman/tambah', function () {
        return view('admin.peminjaman.tambah', [
            'users' => User::all(),
            'bukus' => Buku::where('stok', '>', 0)->get()
        ]);
    });

    Route::post('/peminjaman/simpan', function (Request $request) {
        $jumlahPinjam = Peminjaman::where('user_id', $request->user_id)
                        ->where('status', 'dipinjam')
                        ->count();

        if ($jumlahPinjam >= 2) {
            return back()->with('error', 'Peminjam ini sudah meminjam 2 buku!');
        }

        Peminjaman::create([
            'user_id'           => $request->user_id,
            'buku_id'           => $request->buku_id, 
            'tgl_pinjam'        => $request->tanggal_pinjam, 
            'tgl_kembali_plan'  => $request->tanggal_kembali, 
            'status'            => 'dipinjam',
            'denda'             => 0,
        ]);

        Buku::where('id', $request->buku_id)->decrement('stok', 1);
        return redirect('/peminjaman')->with('success', 'Transaksi berhasil dicatat!');
    });

    // 5. PROSES PENGEMBALIAN & HITUNG DENDA
Route::get('/peminjaman/kembalikan/{id}', function ($id) {
    $pinjam = \App\Models\Peminjaman::findOrFail($id);
    
    if($pinjam->status == 'dipinjam') {
        $hariIni = \Carbon\Carbon::today();
        $jatuhTempo = \Carbon\Carbon::parse($pinjam->tgl_kembali_plan)->startOfDay();

        $denda = 0;
        if ($hariIni->gt($jatuhTempo)) {
            // Gunakan diffInDays tanpa parameter tambahan atau paksa absolut
            $selisihHari = $hariIni->diffInDays($jatuhTempo);
            $denda = $selisihHari * 1000;
        }

        $pinjam->update([
            'status' => 'selesai',
            'denda'  => $denda // Sekarang denda tidak akan pernah minus
        ]);

        \App\Models\Buku::where('id', $pinjam->buku_id)->increment('stok', 1);

        return redirect('/peminjaman')->with('success', 'Berhasil dikembalikan!');
    }
    return back();
});

    Route::get('/peminjaman', function () {
        $semuaPeminjaman = Peminjaman::with(['user', 'buku'])->get();
        return view('admin.peminjaman.index', compact('semuaPeminjaman'));
    });

    Route::get('/pengembalian', function () {
        $riwayatSelesai = Peminjaman::where('status', 'selesai')->with(['user', 'buku'])->get();
        return view('admin.pengembalian.index', compact('riwayatSelesai')); 
    });

    // 6. LAPORAN
    Route::get('/laporan', function (Illuminate\Http\Request $request) {
    $tgl_mulai = $request->tgl_mulai;
    $tgl_selesai = $request->tgl_selesai;

    // Ambil data yang statusnya 'selesai'
    $query = \App\Models\Peminjaman::with(['user', 'buku'])->where('status', 'selesai');

    // Jalankan filter hanya jika user memilih tanggal
    if ($tgl_mulai && $tgl_selesai) {
        $query->whereDate('updated_at', '>=', $tgl_mulai)
              ->whereDate('updated_at', '<=', $tgl_selesai);
    }

    $laporan = $query->get();

    // LOGIKA PERBAIKAN: Pastikan semua denda dihitung sebagai angka positif
    $totalDenda = $laporan->sum(function($item) {
        return abs($item->denda);
    });

    return view('admin.laporan.index', compact('laporan', 'totalDenda', 'tgl_mulai', 'tgl_selesai'));
});

    // Proses kirim reservasi
// Proses Reservasi
Route::post('/reservasi/{id}', function ($id) {
    // 1. Validasi Jam Operasional
    $sekarang = now();
    $hari = $sekarang->format('N'); // 1 (Senin) sampai 7 (Minggu)
    $jam = $sekarang->format('H:i');

    if ($hari <= 5) { // Senin - Jumat
        if ($jam < '09:00' || $jam > '20:00') {
            return back()->with('error', 'Gagal! Reservasi hanya bisa dilakukan saat jam operasional (09:00 - 20:00).');
        }
    } else { // Sabtu - Minggu
        if ($jam < '09:00' || $jam > '15:00') {
            return back()->with('error', 'Gagal! Reservasi hanya bisa dilakukan saat jam operasional (09:00 - 15:00).');
        }
    }

    $buku = \App\Models\Buku::findOrFail($id);

    if ($buku->stok <= 0) {
        return back()->with('error', 'Stok buku habis!');
    }

    $aktif = \App\Models\Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', ['reservasi', 'dipinjam'])
            ->count();
    
    if ($aktif >= 2) {
        return back()->with('error', 'Batas maksimal peminjaman adalah 2 buku.');
    }

    \App\Models\Peminjaman::create([
        'user_id' => Auth::id(),
        'buku_id' => $id,
        'tgl_reservasi' => now(),
        'batas_ambil' => now()->addHours(2),
        'status' => 'reservasi',
    ]);

    $buku->decrement('stok', 1);

    return back()->with('success', 'Berhasil Reservasi! Segera ambil buku dalam 2 jam (sebelum ' . now()->addHours(2)->format('H:i') . ').');
});

// Route untuk melihat buku yang sedang dipinjam
Route::get('/pinjaman-saya', function () {
    $pinjaman = \App\Models\Peminjaman::where('user_id', Auth::id())
                ->with('buku')
                ->orderBy('created_at', 'desc')
                ->get();
    // Kita arahkan ke file baru yang akan kita buat: pinjaman_saya.blade.php
    return view('pinjaman_saya', compact('pinjaman'));
});

Route::get('/peminjaman/ambil/{id}', function ($id) {
    $p = \App\Models\Peminjaman::findOrFail($id);
    
    $p->update([
        'status' => 'dipinjam',
        'tgl_pinjam' => now(),
        'tgl_kembali_plan' => now()->addDays(3), 
    ]);

    return back()->with('success', 'Buku berhasil diambil! Status berubah menjadi DIPINJAM.');
});
});