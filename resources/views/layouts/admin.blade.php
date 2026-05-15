<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard {{ ucfirst(auth()->user()->role) }} | E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f4f1; }
        .sidebar { height: 100vh; width: 250px; position: fixed; background: #2b1506; color: white; transition: all 0.3s; }
        .main-content { margin-left: 250px; min-height: 100vh; }
        .nav-link { color: #d7ccc8; padding: 12px 20px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: white; background: #4e342e; border-radius: 5px; }
        .navbar-admin { background-color: #6b4934; }
        /* Sidebar Menu Aktif: Dari Biru ke Cokelat Tembaga */
.nav-link.active { 
    color: white !important; 
    background: #8d6e63 !important; /* Cokelat tembaga lembut */
}

/* Tombol Logout: Agar lebih kontras di background gelap */
.btn-outline-danger {
    color: #ff8a80 !important;
    border-color: #9c2318 !important;
}
.btn-outline-danger:hover {
    background-color: #c91a0a !important;
    color: white !important;
}
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column p-3 shadow">
        <h4 class="fw-bold mb-4 text-center mt-2"><i class="bi bi-book-half"></i> E-PERPUS</h4>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            </li>
            <li>
                <a href="/katalog-admin" class="nav-link {{ request()->is('katalog-admin*') ? 'active' : '' }}"><i class="bi bi-book me-2"></i> Data Buku</a>
            </li>
            @if(Auth::user()->role == 'admin')
            <li>
                <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}"><i class="bi bi-people me-2"></i> Data Users</a>
            </li>
            @endif
            <li>
                <a href="/peminjaman" class="nav-link {{ request()->is('peminjaman*') ? 'active' : '' }}"><i class="bi bi-cart-check me-2"></i> Peminjaman</a>
            </li>
            <li>
                <a href="/pengembalian" class="nav-link {{ request()->is('pengembalian*') ? 'active' : '' }}"><i class="bi bi-arrow-left-right me-2"></i> Pengembalian</a>
            </li>
            <li>
                <a href="/laporan" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}"><i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan</a>
            </li>
        </ul>
        <div class="small text-center opacity-50 mb-2">© 2026 E-Perpus Digital</div>
    </div>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-dark navbar-admin shadow-sm mb-4 px-4 py-3">
            <div class="container-fluid">
                <span class="navbar-text text-white d-none d-md-inline">
                    Manajemen Perpustakaan Digital
                </span>
                <div class="ms-auto d-flex align-items-center">
                    <span class="text-light me-3 d-none d-md-inline small">Halo, <strong>{{ Auth::user()->name }}</strong></span>
                    <form action="/logout" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="px-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>