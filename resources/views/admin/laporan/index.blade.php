@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 pt-3">
    <h3 class="fw-bold mb-4">Laporan Peminjaman & Pendapatan</h3>

    <div class="card shadow-sm border-0 mb-4 d-print-none">
        <div class="card-body">
            <form action="/laporan" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Dari Tanggal</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="{{ $tgl_mulai }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Sampai Tanggal</label>
                    <input type="date" name="tgl_selesai" class="form-control" value="{{ $tgl_selesai }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter"></i> Filter</button>
                </div>
                <div class="col-md-3">
                    <div class="btn-group w-100">
                        <a href="/laporan" class="btn btn-secondary">Reset</a>
                        <button onclick="window.print()" class="btn btn-success">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-white-50">Total Pendapatan Denda</h6>
                    <h3 class="fw-bold">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-white-50">Total Buku Kembali</h6>
                    <h3 class="fw-bold">{{ $laporan->count() }} Transaksi</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary">Detail Data Transaksi Selesai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->buku->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }}</td>
                            <td class="{{ $item->denda != 0 ? 'text-danger fw-bold' : '' }}">
    @if($item->denda != 0)
        Rp {{ number_format(abs($item->denda), 0, ',', '.') }}
    @else
        <span class="text-success">Tidak ada</span>
    @endif
</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Data tidak ditemukan untuk periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .navbar, .d-print-none, .btn, .btn-group {
        display: none !important;
    }
    .main-content {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }
    .card {
        border: none !important;
        shadow: none !important;
    }
    table {
        border-collapse: collapse !important;
        width: 100% !important;
    }
    table th, table td {
        border: 1px solid #000 !important;
        padding: 8px !important;
    }
}
</style>
@endsection