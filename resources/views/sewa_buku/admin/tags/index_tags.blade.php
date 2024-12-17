@extends('sewa_buku.layouts.app')

@section('style')
@endsection

@section('title')
    Kelola Tags
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kelola Tags</h3>
                <p class="text-subtitle text-muted">Tambah dan kelola daftar tags yang tersedia</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Tags</li>
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
                        <!-- Flash Message -->
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Daftar Tags -->
                        <h5 class="card-title">Daftar Tags</h5>
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Parent Tags</th>
                                        <th>Nama Tags</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tags as $tag)
                                        <tr>
                                            <td>{{ $tag->id_tags }}</td>
                                            <td>{{ $tag->parent->nama_tags ?? '-' }}</td>
                                            <td>{{ $tag->nama_tags }}</td>
                                            <td>{{ $tag->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.tags.edit', $tag->id_tags) }}" class="btn btn-warning btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada tags</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Form Tambah Tags -->
                        <h5 class="card-title mt-5">Tambah Tags Baru</h5>
                        <form action="{{ route('admin.tags.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- ID Child -->
                                <div class="col-md-6 mb-3">
                                    <label for="id_child" class="form-label">ID Child (Optional)</label>
                                    <select name="id_child" class="form-control">
                                        <option value="">-- Pilih Child Tag (Opsional) --</option>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id_tags }}" {{ old('id_child') == $tag->id_tags ? 'selected' : '' }}>
                                                {{ $tag->nama_tags }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_child')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Nama Tags -->
                                <div class="col-md-6 mb-3">
                                    <label for="nama_tags" class="form-label">Nama Tags</label>
                                    <input type="text" name="nama_tags" value="{{ old('nama_tags') }}" class="form-control" placeholder="Masukkan Nama Tags">
                                    @error('nama_tags')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan Tags</button>
                            </div>
                        </form>
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
                    { targets: [0], className: 'text-center' },
                    { targets: [4], orderable: false, searchable: false },
                ],
            });
        });
    </script>
@endsection
