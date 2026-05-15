<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjaman Saya | E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #212529; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/katalog"><i class="bi bi-book-half"></i> E-PERPUS</a>
            <div class="ms-auto d-flex align-items-center">
                <a href="/katalog" class="btn btn-sm btn-outline-light rounded-pill px-3 me-3">
                    <i class="bi bi-grid"></i> Lihat Katalog
                </a>
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
        <h3 class="fw-bold text-dark mb-4">Buku Saya</h3>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Buku</th>
                                <th>Status</th>
                                <th>Keterangan Waktu</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pinjaman as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="fw-bold">{{ $p->buku->judul }}</span><br>
                                    <small class="text-muted">{{ $p->buku->penulis }}</small>
                                </td>
                                <td>
                                    @if($p->status == 'reservasi')
                                        <span class="badge bg-info text-dark">RESERVASI</span>
                                    @elseif($p->status == 'dipinjam')
                                        <span class="badge bg-warning text-dark">DIPINJAM</span>
                                    @elseif($p->status == 'selesai')
                                        <span class="badge bg-success">SELESAI</span>
                                    @else
                                        <span class="badge bg-danger">{{ strtoupper($p->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->status == 'reservasi')
                                        <small class="text-danger fw-bold">Ambil sebelum: {{ \Carbon\Carbon::parse($p->batas_ambil)->format('H:i') }}</small>
                                    @elseif($p->status == 'dipinjam')
                                        <small class="text-primary fw-bold">Batas Kembali: {{ \Carbon\Carbon::parse($p->tgl_kembali_plan)->format('d/m/Y') }}</small>
                                    @elseif($p->status == 'selesai')
                                        <small class="text-muted">Dikembalikan: {{ \Carbon\Carbon::parse($p->updated_at)->format('d/m/Y') }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($p->denda > 0)
                                        <span class="text-danger fw-bold">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-success">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada riwayat peminjaman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>