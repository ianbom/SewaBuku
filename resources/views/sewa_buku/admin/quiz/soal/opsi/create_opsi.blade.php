@extends('sewa_buku.layouts.app')

@section('title')
    Buat Opsi untuk Soal
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Buat Opsi untuk Soal</h3>
                <p class="text-subtitle text-muted">Tambahkan opsi jawaban untuk soal ini.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Buat Opsi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Informasi Soal -->
                        <div class="mb-4">
                            <h4 class="card-title">Informasi Soal</h4>
                            <p>{{ $soal->soal }}</p>
                            @if ($soal->image)
                                <p><strong>Gambar Soal:</strong></p>
                                <img src="{{ asset('storage/' . $soal->image) }}" alt="Gambar Soal" class="img-thumbnail mb-3" style="max-width: 200px;">
                            @endif
                        </div>

                        <!-- Formulir Pembuatan Opsi -->
                        <form action="{{ route('opsi.store', $soal->id_soal) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id_soal" value="{{ $soal->id_soal }}">

                            <!-- Input Opsi -->
                            <div class="mb-3">
                                <label for="opsi" class="form-label">Opsi</label>
                                <input type="text" name="opsi" id="opsi" required class="form-control" placeholder="Masukkan opsi jawaban">
                            </div>

                            <!-- Upload Gambar -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar Opsi (Opsional)</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>

                            <!-- Pilihan Benar atau Salah -->
                            <div class="mb-3">
                                <label for="is_correct" class="form-label">Apakah Opsi Benar?</label>
                                <select name="is_correct" id="is_correct" class="form-select" required>
                                    <option value="1">Benar</option>
                                    <option value="0">Salah</option>
                                </select>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan Opsi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
