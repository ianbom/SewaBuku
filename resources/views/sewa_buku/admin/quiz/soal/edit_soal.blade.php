@extends('sewa_buku.layouts.app')

@section('title')
    Edit Soal
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Soal</h3>
                <p class="text-subtitle text-muted">Perbarui informasi soal.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('quiz.show', $soal->id_quiz) }}">Detail Quiz</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Soal</li>
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
                        <h4 class="card-title mb-4">Form Edit Soal</h4>

                        <!-- Form Edit Soal -->
                        <form action="{{ route('soal.update', $soal->id_soal) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Input Soal -->
                            <div class="mb-3">
                                <label for="soal" class="form-label">Soal</label>
                                <textarea name="soal" id="soal" rows="4" class="form-control" required>{{ old('soal', $soal->soal) }}</textarea>
                                @error('soal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Input Gambar -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar (Opsional)</label>
                                @if($soal->image)
                                    <div class="mb-3">
                                        <img src="{{ Storage::url($soal->image) }}" alt="Gambar Soal" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="text-end">
                                <a href="{{ route('quiz.show', $soal->id_quiz) }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Update Soal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
