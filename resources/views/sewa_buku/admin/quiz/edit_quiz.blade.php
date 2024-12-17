@extends('sewa_buku.layouts.app')

@section('title')
    Edit Quiz
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Quiz</h3>
                <p class="text-subtitle text-muted">Perbarui informasi quiz.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Quiz</li>
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
                        <h4 class="card-title mb-4">Form Edit Quiz</h4>

                        <form action="{{ route('quiz.update', $quiz->id_quiz) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Nama Quiz -->
                            <div class="mb-3">
                                <label for="nama_quiz" class="form-label">Nama Quiz</label>
                                <input type="text" name="nama_quiz" id="nama_quiz" value="{{ old('nama_quiz', $quiz->nama_quiz) }}"
                                       class="form-control @error('nama_quiz') is-invalid @enderror" required>
                                @error('nama_quiz')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4"
                                          class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $quiz->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- File Upload -->
                            <div class="mb-3">
                                <label for="file" class="form-label">File Quiz (Opsional)</label>
                                @if ($quiz->file)
                                    <p class="mb-2">
                                        File saat ini:
                                        <a href="{{ Storage::url($quiz->file) }}" class="text-primary text-decoration-underline" target="_blank">
                                            Lihat file
                                        </a>
                                    </p>
                                @endif
                                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="text-end">
                                <a href="{{ route('quiz.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Update Quiz</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
