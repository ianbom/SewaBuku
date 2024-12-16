@extends('sewa_buku.layouts.app')

@section('style')
@endsection

@section('title')
    Daftar Pengguna
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Pengguna</h3>
                    <p class="text-subtitle text-muted">Kelola data pengguna aplikasi</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Pengguna</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2">
                                <h5 class="card-title">Data Pengguna</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="table-1" class="table table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No. HP</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $index => $u)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $u->name }}</td>
                                                <td>{{ $u->email }}</td>
                                                <td>{{ $u->no_hp ?? 'N/A' }}</td>
                                                <td>{{ $u->tanggal_lahir ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($u->is_admin)
                                                        <span class="badge bg-success">Admin</span>
                                                    @else
                                                        <span class="badge bg-secondary">Pengguna</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-info btn-sm">Detail</a>
                                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="#" method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#table-1').DataTable({
                responsive: true,
                columnDefs: [
                    {
                        targets: [0],
                        className: 'text-center'
                    },
                    {
                        targets: [6],
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endsection
