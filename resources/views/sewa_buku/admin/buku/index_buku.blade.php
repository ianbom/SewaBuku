@extends('sewa_buku.layouts.app')

@section('style')
@endsection

@section('title')
    Daftar Buku
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Buku</h3>
                    <p class="text-subtitle text-muted">Kelola daftar buku di perpustakaan</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Buku</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Buku</li>
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
                                <h5 class="card-title">Data Buku</h5>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.buku.create') }}" class="btn btn-info btn-rounded m-t-10 mb-2">
                                    Tambah Buku Baru
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="table-1" class="table table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Buku</th>
                                            <th>Penulis</th>
                                            <th>Penerbit</th>
                                            <th>ISBN</th>
                                            <th>Tahun Terbit</th>
                                            <th>Teaser Audio</th>
                                            <th>Sinopsis</th>
                                            <th>Ringkasan Audio</th>
                                            <th>Gratis</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($buku as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->judul_buku }}</td>
                                                <td>{{ $item->penulis }}</td>
                                                <td>{{ $item->penerbit }}</td>
                                                <td>{{ $item->isbn }}</td>
                                                <td>{{ $item->tahun_terbit }}</td>
                                                <td>
                                                    <audio controls>
                                                        <source src="{{ asset('storage/' . $item->teaser_audio) }}"
                                                            type="audio/mp3">
                                                        Browser Anda tidak mendukung pemutar audio.
                                                    </audio>
                                                </td>
                                                <td>{{ Str::limit($item->sinopsis, 100) }}</td>
                                                <td>
                                                    <audio controls>
                                                        <source src="{{ asset('storage/' . $item->ringkasan_audio) }}"
                                                            type="audio/mp3">
                                                        Browser Anda tidak mendukung pemutar audio.
                                                    </audio>
                                                </td>
                                                <td>{{ $item->is_free ? 'Gratis' : 'Berbayar' }}</td>
                                                <td>
                                                    <a href="{{ route('admin.buku.edit', $item->id_buku) }}"
                                                        class="btn btn-warning btn-sm">
                                                        Edit
                                                    </a>
                                                    <a href="{{ route('admin.buku.show', $item->id_buku) }}" class="btn btn-success">
                                                        Detail
                                                    </a>
                                                    <a href="#deleteData" class="btn btn-danger btn-sm"
                                                        {{-- data-delete-url="{{ route('admin.buku.destroy', $item->id_buku) }}" --}}
                                                        onclick="return deleteConfirm(this, 'delete')">
                                                        Hapus
                                                    </a>
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
                columnDefs: [{
                        targets: [0],
                        className: 'text-center'
                    },
                    {
                        targets: [7, 9],
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });

        function deleteConfirm(element, action) {
            let url = $(element).data('delete-url');
            if (confirm('Apakah Anda yakin ingin ' + action + ' data ini?')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function() {
                        alert('Gagal ' + action + ' data.');
                    }
                });
            }
            return false;
        }
    </script>
@endsection
