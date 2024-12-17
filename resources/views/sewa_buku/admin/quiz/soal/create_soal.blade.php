@extends('sewa_buku.layouts.app')

@section('title')
    Tambah Soal untuk Quiz
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Soal</h3>
                <p class="text-subtitle text-muted">Tambahkan soal baru untuk quiz: {{ $quiz->nama_quiz }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('quiz.show', $quiz->id_quiz) }}">Detail Quiz</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Soal</li>
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
                        <h4 class="card-title mb-4">Form Tambah Soal</h4>

                        <form action="{{ route('soal.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- ID Quiz (Hidden) -->
                            <input type="hidden" name="id_quiz" value="{{ $quiz->id_quiz }}">

                            <!-- Input Soal -->
                            <div class="mb-3">
                                <label for="soal" class="form-label">Soal</label>
                                <textarea name="soal" id="soal" rows="4" class="form-control"
                                          placeholder="Masukkan soal..." required>{{ old('soal') }}</textarea>
                                @error('soal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Gambar Soal (Opsional) -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar (Opsional)</label>
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="text-end">
                                <a href="{{ route('quiz.show', $quiz->id_quiz) }}" class="btn btn-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Simpan Soal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
