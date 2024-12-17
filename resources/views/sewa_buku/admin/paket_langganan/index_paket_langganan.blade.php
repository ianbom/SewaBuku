@extends('sewa_buku.layouts.app')

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
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('paket-langganan.create') }}" class="btn btn-primary">
                                Tambah Paket Langganan
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Nama Paket</th>
                                        <th>Harga</th>
                                        <th>Masa Waktu (Hari)</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
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
                                                <a href="{{ route('paket-langganan.edit', $paket->id_paket_langganan) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('paket-langganan.destroy', $paket->id_paket_langganan) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus paket ini?')">
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
