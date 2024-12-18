@extends('sewa_buku.layouts.app')
@section('style')
@endsection

@section('title')
    Daftar Pesanan
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Pesanan</h3>
                    <p class="text-subtitle text-muted">Kelola daftar pesanan buku</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Pesanan</li>
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
                                <h5 class="card-title">Data Pesanan</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="table-1" class="table table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID Order</th>
                                            <th>Nama User</th>
                                            <th>Paket</th>
                                            <th>Total Bayar</th>
                                            <th>Status</th>
                                            <th>Tanggal Order</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order as $item)
                                            <tr>
                                                <td>{{ $item->id_order }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>{{ $item->nama_paket ?? '-' }}</td>
                                                <td>Rp{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                                <td>
                                                    @if ($item->status_order == 'Dibayar')
                                                        <span class="badge bg-success">Dibayar</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $item->status_order }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ date('d M Y', strtotime($item->created_at)) }}</td>
                                                <td>
                                                    <a href="{{ route('admin.order.show', $item->id_order) }}"
                                                        class="btn btn-primary btn-sm">Detail</a>
                                                    {{-- <form action="{{ route('admin.order.delete', $item->id_order) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">Hapus</button>
                                                    </form> --}}
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
