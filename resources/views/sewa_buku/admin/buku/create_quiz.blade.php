@extends('sewa_buku.layouts.app')

@section('title')
    Buat Quiz
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Buat Quiz</h3>
                <p class="text-subtitle text-muted">Untuk buku: {{ $buku->judul_buku }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.buku.edit', $buku->id_buku) }}">Edit Buku</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Buat Quiz</li>
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
                        <h4 class="card-title mb-4">Form Buat Quiz</h4>
                        <p>Membuat quiz untuk detail bab: <strong>{{ $detailBuku->bab }}</strong></p>

                        <form action="{{ route('quiz.store', $detailBuku->id_detail_buku) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id_detail_buku" value="{{ $detailBuku->id_detail_buku }}">

                            <!-- Nama Quiz -->
                            <div class="mb-3">
                                <label for="nama_quiz" class="form-label">Nama Quiz</label>
                                <input type="text" name="nama_quiz" id="nama_quiz" class="form-control" placeholder="Masukkan nama quiz" required>
                                @error('nama_quiz')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control" placeholder="Masukkan deskripsi quiz"></textarea>
                                @error('deskripsi')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- File PDF/Image -->
                            <div class="mb-3">
                                <label for="file" class="form-label">File PDF/Image (Opsional)</label>
                                <input type="file" name="file" id="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format yang diperbolehkan: PDF, JPG, JPEG, PNG</small>
                                @error('file')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end mt-4">
                                <a href="{{ route('admin.buku.edit', $buku->id_buku) }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Buat Quiz</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
