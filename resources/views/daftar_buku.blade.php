<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku | E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #212529; }
        .card-buku { 
            transition: transform 0.2s; 
            border: none; 
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .card-buku:hover { 
            transform: scale(1.03); 
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .book-cover {
            height: 250px;
            object-fit: cover;
            background-color: #e9ecef;
        }
        /* Memastikan card-body mengambil sisa ruang agar footer tetap di bawah */
        .card-body { flex: 1 1 auto; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/katalog"><i class="bi bi-book-half"></i> E-PERPUS</a>
            <div class="ms-auto d-flex align-items-center">
                <span class="text-light me-3 d-none d-md-inline">Halo, <strong>{{ Auth::user()->name }}</strong></span>
                <form action="/logout" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h3 class="fw-bold text-dark">Katalog Buku</h3>
                <p class="text-muted">Temukan dan reservasi buku favoritmu di sini.</p>
            </div>
            <div class="col-md-6">
                <form action="/katalog" method="GET">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="cari" class="form-control border-start-0 ps-0" 
                               placeholder="Cari judul buku atau penulis..." value="{{ request('cari') }}">
                        <button class="btn btn-dark px-4" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse($semuaBuku as $buku)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm card-buku">
                    <img src="{{ asset('img/' . $buku->gambar) }}" 
                         class="card-img-top book-cover" 
                         alt="Cover {{ $buku->judul }}"
                         onerror="this.onerror=null;this.src='https://placehold.co/300x400?text=Gambar+Tidak+Ada';">
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-light text-dark border small">{{ $buku->tahun_terbit }}</span>
                            <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }} small">
                                Stok: {{ $buku->stok }}
                            </span>
                        </div>
                        <h6 class="card-title fw-bold text-dark mb-1 text-truncate" title="{{ $buku->judul }}">
                            {{ $buku->judul }}
                        </h6>
                        <p class="card-text small text-muted mb-0">
                            <i class="bi bi-person text-secondary"></i> {{ $buku->penulis }}
                        </p>
                    </div>
                    
                    <div class="card-footer bg-transparent border-0 d-grid pb-3">
                        <form action="/reservasi/{{ $buku->id }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-dark btn-sm rounded-pill py-2 w-100" {{ $buku->stok == 0 ? 'disabled' : '' }}>
                                {{ $buku->stok > 0 ? 'Reservasi Sekarang' : 'Stok Habis' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-journal-x" style="font-size: 4rem; color: #dee2e6;"></i>
                </div>
                <h5 class="text-muted">Buku "{{ request('cari') }}" tidak ditemukan.</h5>
                <a href="/katalog" class="btn btn-outline-dark btn-sm rounded-pill mt-2">Lihat Semua Koleksi</a>
            </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>