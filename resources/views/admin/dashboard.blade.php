@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pt-2 pb-2 mb-4">
        <h3 class="fw-bold" style="color: #2b1506;">Dashboard Utama</h3>
        <div class="text-muted small">{{ now()->format('l, d F Y') }}</div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-white h-100" style="background: linear-gradient(135deg, #4e342e, #2b1506); border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Total Koleksi Buku</div>
                            <div class="display-6 fw-bold mt-1">{{ $jumlahBuku }}</div>
                        </div>
                        <i class="bi bi-journal-bookmark fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-white h-100" style="background: linear-gradient(135deg, #8d6e63, #5d4037); border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Total Pengguna</div>
                            <div class="display-6 fw-bold mt-1">{{ $jumlahUser }}</div>
                        </div>
                        <i class="bi bi-people fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-white h-100" style="background: linear-gradient(135deg, #ad8b6a, #8d6e63); border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Sedang Dipinjam</div>
                            <div class="display-6 fw-bold mt-1">{{ $jumlahPinjam }}</div>
                        </div>
                        <i class="bi bi-cart-check fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-2" style="border-radius: 15px;">
        <div class="card-body p-4">
            <h5 class="fw-bold" style="color: #4e342e;">Selamat Datang, {{ Auth::user()->name }}!</h5>
            <p class="text-muted mb-0">Gunakan menu di sebelah kiri untuk mengelola data perpustakaan digital Anda.</p>
        </div>
    </div>
</div>
@endsection