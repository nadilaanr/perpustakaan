@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Utama</h1>
    </div>

    <!-- Baris Card Statistik -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-white-50">Total Koleksi Buku</div>
                            <div class="display-6 fw-bold">{{ $jumlahBuku }}</div>
                        </div>
                        <i class="bi bi-book fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-white-50">Total Pengguna</div>
                            <div class="display-6 fw-bold">{{ $jumlahUser }}</div>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-dark-50">Sedang Dipinjam</div>
                            <div class="display-6 fw-bold">{{ $jumlahPinjam }}</div>
                        </div>
                        <i class="bi bi-cart-check fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <h4>Selamat Datang, {{ Auth::user()->name }}!</h4>
            <p class="text-muted">Ini adalah halaman dashboard admin untuk mengelola sirkulasi buku, data anggota, dan laporan perpustakaan.</p>
        </div>
    </div>
</div>
@endsection