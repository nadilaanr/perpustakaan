@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4"> <!-- Tambahan container agar lebih rapi -->
    <div class="d-flex justify-content-between align-items-center mb-4 pt-3">
        @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
        <h3 class="fw-bold">Data Pengguna</h3>
        <a href="/users/tambah" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus"></i> Tambah Pengguna
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive"> <!-- Tambahan agar tabel aman di layar HP -->
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($semuaUser as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group gap-1">
                                    
                                    <a href="/users/edit/{{ $user->id }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <!-- Form Hapus User -->
                                    <form action="/users/{{ $user->id }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- End table-responsive -->
        </div>
    </div>
</div>
@endsection