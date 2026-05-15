<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            /* Background gradient yang elegan */
            background: rgba(243, 228, 216, 0.95);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-login {
            border-radius: 20px;
            border: none;
            width: 100%;
            max-width: 420px;
            overflow: hidden;
            background: rgba(173, 139, 106, 0.95);
            backdrop-filter: blur(10px);
        }
        .login-header {
            background-color: #2b1506;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(118, 75, 162, 0.25);
            border-color: #764ba2;
        }
        .btn-login {
            background: linear-gradient(to right, #3a180a, #5f4818);
            border: none;
            color: white;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>

<div class="card card-login shadow-2xl">
    <div class="login-header">
        <i class="bi bi-book-half fs-1"></i>
        <h4 class="fw-bold mt-2 mb-0">E-PERPUS</h4>
        <p class="small opacity-75 mb-0">Silakan masuk ke akun Anda</p>
    </div>
    <div class="card-body p-4 p-md-5">
        
        @if($errors->any())
            <div class="alert alert-danger py-2 small border-0 shadow-sm">
                <i class="bi bi-exclamation-circle me-2"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control border-start-0" placeholder="nama@email.com" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control border-start-0" placeholder="Masukkan password" required>
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-login rounded-pill py-2 shadow-sm">Masuk Sekarang</button>
            </div>
        </form>

        <div class="text-center mt-4 small text-muted">
            Belum punya akun? <a href="/register" class="text-primary fw-bold text-decoration-none">Daftar Akun</a>
        </div>
    </div>
</div>

</body>
</html>