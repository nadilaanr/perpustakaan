<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Perpus</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            border-radius: 15px;
            border: none;
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="card card-login shadow-lg">
    <div class="card-body p-5">
        <h3 class="text-center fw-bold mb-4">LOGIN</h3>

        {{-- Pesan Error jika login gagal --}}
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-dark rounded-pill py-2">Masuk Sekarang</button>
            </div>
        </form>

        <div class="text-center mt-3 small">
            Belum punya akun? <a href="/register" class="text-decoration-none">Daftar di sini</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>