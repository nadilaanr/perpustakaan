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
                            <th>Jatuh Tempo</th>
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
                            <td>{{ $p->tgl_pinjam ? \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $p->tgl_kembali_plan ? \Carbon\Carbon::parse($p->tgl_kembali_plan)->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($p->status == 'dipinjam')
                                    <span class="badge bg-warning text-dark">DIPINJAM</span>
                                @elseif($p->status == 'reservasi')
                                    <span class="badge bg-info text-dark">RESERVASI</span>
                                @elseif($p->status == 'selesai')
                                    <span class="badge bg-success">SELESAI</span>
                                @else
                                    <span class="badge bg-danger">{{ strtoupper($p->status) }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{-- CEK ROLE PETUGAS --}}
                                @if(strtolower(Auth::user()->role) == 'petugas')
                                    
                                    @if($p->status == 'dipinjam')
                                        <a href="/peminjaman/kembalikan/{{ $p->id }}" class="btn btn-success btn-sm">
                                            <i class="bi bi-arrow-return-left"></i> Kembalikan
                                        </a>
                                    @elseif($p->status == 'reservasi')
                                        <a href="/peminjaman/ambil/{{ $p->id }}" class="btn btn-info btn-sm text-white">
                                            <i class="bi bi-hand-thumbs-up"></i> Konfirmasi Ambil
                                        </a>
                                    @elseif($p->status == 'selesai')
                                        <span class="badge bg-secondary">Sudah Kembali</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif

                                @else
                                    {{-- JIKA LOGIN BUKAN PETUGAS --}}
                                    <span class="text-muted small">Hanya Petugas</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
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