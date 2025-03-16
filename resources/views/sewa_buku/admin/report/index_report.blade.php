@extends('sewa_buku.layouts.app')

@section('style')
@endsection

@section('title')
    Daftar Laporan
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Laporan</h3>
                    <p class="text-subtitle text-muted">Kelola daftar laporan buku</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Laporan</li>
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
                                <h5 class="card-title">Data Laporan</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="table-report" class="table table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID Report</th>
                                            <th>Nama User</th>
                                            <th>Judul Buku</th>
                                            <th>Alasan</th>
                                            <th>Tanggal Laporan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($report as $item)
                                            <tr>
                                                <td>{{ $item->id_report }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>{{ $item->buku->judul_buku }}</td>
                                                <td>{{ $item->alasan }}</td>
                                                <td>{{ date('d M Y', strtotime($item->created_at)) }}</td>
                                                <td>
                                                    <a href="{{ route('report.show', $item->id_report) }}" class="btn btn-primary btn-sm">Detail</a>
                                                    <form action="{{ route('report.destroy', $item->id_report) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus laporan ini?')">Hapus</button>
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
            $('#table-report').DataTable({
                responsive: true,
                columnDefs: [
                    {
                        targets: [0],
                        className: 'text-center'
                    },
                    {
                        targets: [5],
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endsection
