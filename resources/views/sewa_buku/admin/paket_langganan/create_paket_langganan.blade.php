@extends('sewa_buku.layouts.app')

@section('title')
    Buat Paket Langganan Baru
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Buat Paket Langganan Baru</h3>
                <p class="text-subtitle text-muted">Tambahkan paket langganan baru untuk pengguna.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('paket-langganan.index') }}">Paket Langganan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Buat Paket Baru</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="form-section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="paketLanggananForm" action="{{ route('paket-langganan.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Nama Paket -->
                                <div class="col-md-6 mb-3">
                                    <label for="nama_paket" class="form-label">Nama Paket</label>
                                    <input type="text" name="nama_paket" id="nama_paket" required
                                        class="form-control" placeholder="Nama Paket">
                                </div>

                                <!-- Harga -->
                                <div class="col-md-6 mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" step="0.01" name="harga" id="harga" required
                                        class="form-control" placeholder="Harga Paket">
                                </div>

                                <!-- Masa Waktu -->
                                <div class="col-md-6 mb-3">
                                    <label for="masa_waktu" class="form-label">Masa Waktu (Hari)</label>
                                    <input type="number" name="masa_waktu" id="masa_waktu" required
                                        class="form-control" placeholder="Masa Waktu Paket">
                                </div>

                                <!-- Status Aktif -->
                                <div class="col-md-6 mb-3">
                                    <label for="is_active" class="form-label">Status Aktif</label>
                                    <select id="is_active" name="is_active" class="form-control">
                                        <option value="1" selected>Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-12 mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" rows="5" required
                                        class="form-control" placeholder="Deskripsi Paket"></textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <a href="{{ route('paket-langganan.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Paket</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
