@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Manajemen Data Buku</h3>
        <a href="/buku/tambah" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Buku Baru</a>
    </div>

<div class="row mb-3">
    <div class="col-md-4">
        <form action="/katalog-admin" method="GET" class="d-flex">
            <input type="text" name="cari" class="form-control me-2" placeholder="Cari buku..." value="{{ request('cari') }}">
            <button type="submit" class="btn btn-dark">Cari</button>
        </form>
    </div>
</div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Cover</th>
                        <th>Judul & Penulis</th>
                        <th>Penerbit/Tahun</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($semuaBuku as $buku)
                    <tr>
                        <td>
                            <img src="{{ asset('img/' . $buku->gambar) }}" width="50" class="rounded shadow-sm" onerror="this.src='https://placehold.co/50x70?text=No+Img'">
                        </td>
                        <td>
                            <div class="fw-bold">{{ $buku->judul }}</div>
                            <small class="text-muted">{{ $buku->penulis }}</small>
                        </td>
                        <td>{{ $buku->penerbit }} ({{ $buku->tahun_terbit }})</td>
                        <td>
                            <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $buku->stok }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="/buku/edit/{{ $buku->id }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="/buku/{{ $buku->id }}" method="POST" onsubmit="return confirm('Yakin hapus buku ini?')">
                        @csrf
                        @method('DELETE')
            
    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
</form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection