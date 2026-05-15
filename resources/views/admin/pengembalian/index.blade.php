@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-3">
        <h3 class="fw-bold">Riwayat Pengembalian Buku</h3>
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
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Denda</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatSelesai as $index => $r)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $r->user->name }}</td>
                            <td>{{ $r->buku->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->tgl_pinjam)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->updated_at)->format('d/m/Y') }}</td>
                            <td>
    @if($r->denda != 0)
        <span class="text-danger fw-bold">Rp {{ number_format(abs($r->denda), 0, ',', '.') }}</span>
    @else
        <span class="text-success">Tidak ada</span>
    @endif
</td>
                            <td><span class="badge bg-secondary text-capitalize">{{ $r->status }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada riwayat pengembalian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection