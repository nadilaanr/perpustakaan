@extends('layouts.app') @section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Pinjaman Saya</h3>
        <a href="/daftar-buku" class="btn btn-outline-primary btn-sm">Kembali ke Katalog</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Info Buku</th>
                            <th>Status</th>
                            <th>Waktu Penting</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pinjaman as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-bold">{{ $p->buku->judul }}</span><br>
                                <small class="text-muted">Kategori: {{ $p->buku->kategori->nama_kategori ?? '-' }}</small>
                            </td>
                            <td>
                                @if($p->status == 'reservasi')
                                    <span class="badge bg-info text-dark">RESERVASI</span>
                                @elseif($p->status == 'dipinjam')
                                    <span class="badge bg-warning text-dark">DIPINJAM</span>
                                @elseif($p->status == 'selesai')
                                    <span class="badge bg-success">SELESAI</span>
                                @else
                                    <span class="badge bg-danger text-uppercase">{{ $p->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if($p->status == 'reservasi')
                                    <span class="text-danger small fw-bold">Ambil sebelum: {{ \Carbon\Carbon::parse($p->batas_ambil)->format('H:i') }}</span>
                                @elseif($p->status == 'dipinjam')
                                    <span class="text-primary small fw-bold">Batas Kembali: {{ \Carbon\Carbon::parse($p->tgl_kembali_plan)->format('d/m/Y') }}</span>
                                @elseif($p->status == 'selesai')
                                    <small class="text-muted">Kembali pada: {{ \Carbon\Carbon::parse($p->updated_at)->format('d/m/Y') }}</small>
                                @endif
                            </td>
                            <td>
                                @if($p->denda > 0)
                                    <span class="text-danger fw-bold text-nowrap">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-success small">Rp 0</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada transaksi peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection