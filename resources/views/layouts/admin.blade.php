<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .sidebar { height: 100vh; width: 250px; position: fixed; background: #212529; color: white; }
        .main-content { margin-left: 250px; padding: 20px; }
        .nav-link { color: #adb5bd; }
        .nav-link:hover, .nav-link.active { color: white; background: #343a40; }
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column p-3">
        <h4 class="fw-bold mb-4 text-center">E-PERPUS</h4>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            </li>
            <li>
                <a href="/katalog-admin" class="nav-link"><i class="bi bi-book"></i> Data Buku</a>
            </li>
                @if(Auth::user()->role == 'admin')
<li>
    <a href="/users" class="nav-link">
        <i class="bi bi-people"></i> Data Users
    </a>
</li>
@endif
            </li>
            <li>
                <a href="/peminjaman" class="nav-link"><i class="bi bi-cart-check"></i> Peminjaman</a>
            </li>
            <li>
                <a href="/pengembalian" class="nav-link"><i class="bi bi-arrow-left-right"></i> Pengembalian</a>
            </li>
            <li>
                <a href="/laporan" class="nav-link"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
            </li>
        </ul>
        <hr>
        <form action="/logout" method="POST">
            @csrf
            <button class="btn btn-danger w-100 btn-sm">Logout</button>
        </form>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

</body>
</html>