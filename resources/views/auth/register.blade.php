<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun | E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .register-card { width: 450px; border-radius: 15px; border: none; }
    </style>
</head>
<body>
    <div class="card register-card shadow">
        <div class="card-body p-5">
            <h3 class="text-center fw-bold mb-4">Daftar Akun</h3>
            <form action="/register" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 5 karakter" required>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-dark btn-lg rounded-pill">Daftar Sekarang</button>
                </div>
            </form>
            <div class="text-center mt-3 small">
                Sudah punya akun? <a href="/login">Login di sini</a>
            </div>
        </div>
    </div>
</body>
</html>