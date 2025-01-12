@extends('sewa_buku.layouts.app')

@section('style')
@endsection

@section('title')
    Daftar Paket Langganan
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Paket Langganan</h3>
                    <p class="text-subtitle text-muted">Kelola daftar paket langganan yang tersedia.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Paket Langganan</li>
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

                            <!-- Tombol Tambah Paket -->
                            <div class="d-flex justify-content-end mb-3">
                                <a href="#createPaket" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createPaketModal">
                                    Tambah Paket Langganan
                                </a>
                            </div>

                            <!-- Daftar Paket Langganan -->
                            <h5 class="card-title">Daftar Paket Langganan</h5>
                            <div class="table-responsive">
                                <table id="table-1" class="table table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Nama Paket</th>
                                            <th>Harga</th>
                                            <th>Masa Waktu (Hari)</th>
                                            <th>Deskripsi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($paketLangganan as $paket)
                                            <tr>
                                                <td>{{ $paket->nama_paket }}</td>
                                                <td>Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                                                <td>{{ $paket->masa_waktu }} hari</td>
                                                <td>{{ Str::limit($paket->deskripsi, 50) }}</td>
                                                <td>{{ $paket->is_active ? 'Aktif' : 'Non-Aktif' }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('paket-langganan.edit', $paket->id_paket_langganan) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form
                                                        action="{{ route('paket-langganan.destroy', $paket->id_paket_langganan) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Yakin ingin menghapus paket ini?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Belum ada paket langganan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Form Tambah Paket Langganan -->
                            {{-- <h5 class="card-title mt-5">Tambah Paket Langganan Baru</h5>
                        <form action="{{ route('paket-langganan.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Nama Paket -->
                                <div class="col-md-6 mb-3">
                                    <label for="nama_paket" class="form-label">Nama Paket</label>
                                    <input type="text" name="nama_paket" class="form-control" placeholder="Masukkan Nama Paket">
                                    @error('nama_paket')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Harga -->
                                <div class="col-md-6 mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga">
                                    @error('harga')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Masa Waktu -->
                                <div class="col-md-6 mb-3">
                                    <label for="masa_waktu" class="form-label">Masa Waktu (Hari)</label>
                                    <input type="number" name="masa_waktu" class="form-control" placeholder="Masukkan Masa Waktu">
                                    @error('masa_waktu')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-6 mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" placeholder="Masukkan Deskripsi"></textarea>
                                    @error('deskripsi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan Paket</button>
                            </div>
                        </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal Form -->
    <div class="modal fade" id="createPaketModal" tabindex="-1" aria-labelledby="createPaketModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPaketModalLabel">Buat Paket Langganan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="paketLanggananForm">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_paket" class="form-label">Nama Paket</label>
                            <input type="text" name="nama_paket" id="nama_paket" required class="form-control"
                                placeholder="Nama Paket">
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" step="0.01" name="harga" id="harga" required class="form-control"
                                placeholder="Harga Paket">
                        </div>
                        <div class="mb-3">
                            <label for="masa_waktu" class="form-label">Masa Waktu (Hari)</label>
                            <input type="number" name="masa_waktu" id="masa_waktu" required class="form-control"
                                placeholder="Masa Waktu Paket">
                        </div>
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status Aktif</label>
                            <select id="is_active" name="is_active" class="form-control">
                                <option value="1" selected>Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" required class="form-control" placeholder="Deskripsi Paket"></textarea>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="savePaketBtn">Simpan Paket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                        targets: [5],
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            // Save data via AJAX
            $('#savePaketBtn').on('click', function() {
                const formData = new FormData(document.getElementById('paketLanggananForm'));
                ajaxSaveDatas({
                    url: "{{ route('paket-langganan.store') }}",
                    method: 'POST',
                    input: formData,
                    processData: false,
                    contentType: false,
                    modal: $('#createPaketModal'),
                    reload: true
                });
            });

        });
    </script>
@endsection
