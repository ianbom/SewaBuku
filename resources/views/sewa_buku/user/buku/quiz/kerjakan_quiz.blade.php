@extends('sewa_buku.layouts.userApp')

@section('title')
    Kerjakan Quiz
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kerjakan Quiz</h3>
                <p class="text-subtitle text-muted">Jawab pertanyaan untuk quiz ini.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('quiz.index') }}">Quiz</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kerjakan Quiz</li>
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
                        <!-- Informasi Quiz -->
                        <h4 class="card-title mb-4">Informasi Quiz</h4>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Nama Quiz:</h6>
                                <p>{{ $quiz->nama_quiz }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Deskripsi Quiz:</h6>
                                <p>{{ $quiz->deskripsi }}</p>
                            </div>
                        </div>

                        <!-- Daftar Soal -->
                        <form action="{{ route('user.quiz.submit', $quiz->id_quiz) }}" method="POST">
                            @csrf
                            <h4 class="card-title mb-4">Daftar Soal</h4>
                            @foreach ($soal as $key => $item)
                                <div class="mb-4">
                                    <h5>Soal {{ $key + 1 }}</h5>
                                    <p>{{ $item->soal }}</p>
                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Gambar Soal" class="img-thumbnail mb-3" style="max-width: 200px;">
                                    @endif

                                    <!-- Opsi -->
                                    <div>
                                        @foreach ($item->opsi as $opsi)
                                            <div class="form-check mb-2">
                                                <input type="radio" name="jawaban[{{ $item->id_soal }}]" value="{{ $opsi->id_opsi }}" id="opsi-{{ $opsi->id_opsi }}" class="form-check-input" required>
                                                <label for="opsi-{{ $opsi->id_opsi }}" class="form-check-label">
                                                    {{ $opsi->opsi }}
                                                    @if ($opsi->image)
                                                        <img src="{{ asset('storage/' . $opsi->image) }}" alt="Gambar Opsi" class="img-thumbnail mt-2" style="max-width: 100px;">
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <!-- Tombol Submit -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Submit Quiz</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
