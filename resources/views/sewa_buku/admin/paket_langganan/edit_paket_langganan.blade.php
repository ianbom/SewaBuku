@extends('sewa_buku.layouts.app')

@section('title')
    Edit Paket Langganan
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Paket Langganan</h3>
                <p class="text-subtitle text-muted">Perbarui informasi paket langganan.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('paket-langganan.index') }}">Paket Langganan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Paket Langganan</li>
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
                        <form action="{{ route('paket-langganan.update', $paketLangganan->id_paket_langganan) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Nama Paket -->
                                <div class="col-md-6 mb-3">
                                    <label for="nama_paket" class="form-label">Nama Paket</label>
                                    <input type="text" id="nama_paket" name="nama_paket" value="{{ old('nama_paket', $paketLangganan->nama_paket) }}"
                                        class="form-control" placeholder="Masukkan Nama Paket" required>
                                </div>

                                <!-- Harga -->
                                <div class="col-md-6 mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" step="0.01" id="harga" name="harga" value="{{ old('harga', $paketLangganan->harga) }}"
                                        class="form-control" placeholder="Masukkan Harga Paket" required>
                                </div>

                                <!-- Masa Waktu -->
                                <div class="col-md-6 mb-3">
                                    <label for="masa_waktu" class="form-label">Masa Waktu (Hari)</label>
                                    <input type="number" id="masa_waktu" name="masa_waktu" value="{{ old('masa_waktu', $paketLangganan->masa_waktu) }}"
                                        class="form-control" placeholder="Masukkan Masa Waktu (Hari)" required>
                                </div>

                                <!-- Status Aktif -->
                                <div class="col-md-6 mb-3">
                                    <label for="is_active" class="form-label">Status Aktif</label>
                                    <select id="is_active" name="is_active" class="form-control">
                                        <option value="1" {{ old('is_active', $paketLangganan->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active', $paketLangganan->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-12 mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" rows="4"
                                        class="form-control" placeholder="Masukkan Deskripsi Paket" required>{{ old('deskripsi', $paketLangganan->deskripsi) }}</textarea>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="text-end mt-4">
                                <a href="{{ route('paket-langganan.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
