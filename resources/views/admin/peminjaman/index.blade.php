@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-3">
        <h3 class="fw-bold">Data Transaksi Peminjaman</h3>
        <a href="/peminjaman/tambah" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Transaksi
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semuaPeminjaman as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->user->name }}</td>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tgl_kembali_plan)->format('d M Y') }}</td>
                            <td>
                                <span class="badge {{ $p->status == 'dipinjam' ? 'bg-warning text-dark' : 'bg-success' }}">
                                    {{ strtoupper($p->status) }}
                                </span>
                            </td>
                            <td>
    @if(Auth::user()->role == 'petugas' && $p->status == 'dipinjam')
        <a href="/peminjaman/kembalikan/{{ $p->id }}" class="btn btn-success btn-sm">
            <i class="bi bi-arrow-return-left"></i> Kembalikan
        </a>
    @elseif($p->status == 'selesai')
        <span class="badge bg-secondary">Sudah Kembali</span>
    @else
        <span class="text-muted">-</span>
    @endif
</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-info-circle d-block mb-2 fs-3"></i>
                                Belum ada data peminjaman saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection