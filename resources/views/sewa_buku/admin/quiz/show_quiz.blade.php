@extends('sewa_buku.layouts.app')

@section('title')
    Detail Quiz
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Quiz</h3>
                <p class="text-subtitle text-muted">Informasi dan pengelolaan quiz.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Quiz</li>
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
                                <p>{{ $quiz->nama_quiz ?? 'null' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Deskripsi:</h6>
                                <p>{{ $quiz->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                            </div>
                            @if ($quiz->file)
                            <div class="col-md-6">
                                <h6>File Quiz:</h6>
                                <a href="{{ asset('storage/' . $quiz->file) }}" target="_blank" class="text-primary text-decoration-underline">
                                    Download File
                                </a>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <h6>Tanggal Dibuat:</h6>
                                <p>{{ $quiz->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Terakhir Diperbarui:</h6>
                                <p>{{ $quiz->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Daftar Soal -->
                        <h4 class="card-title mb-4">Daftar Soal</h4>
                        @if ($soal->isNotEmpty())
                        <div class="accordion" id="soalAccordion">
                            @foreach ($soal as $index => $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                        Soal {{ $index + 1 }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                                     aria-labelledby="heading{{ $index }}" data-bs-parent="#soalAccordion">
                                    <div class="accordion-body">
                                        <p><strong>Soal:</strong> {{ $item->soal }}</p>
                                        @if ($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Gambar Soal" class="img-thumbnail mb-3" style="max-width: 200px;">
                                        @endif
                                        <div class="d-flex gap-2 mb-3">
                                            <a href="{{ route('soal.edit', $item->id_soal) }}" class="btn btn-sm btn-warning">Edit Soal</a>
                                            <form action="{{ route('soal.destroy', $item->id_soal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus Soal</button>
                                            </form>
                                        </div>

                                        <!-- Opsi -->
                                        <h6>Opsi:</h6>
                                        @if ($item->opsi->isNotEmpty())
                                        <ol class="list-group list-group-numbered">
                                            @foreach ($item->opsi as $opsi)
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <p>{{ $opsi->opsi }}</p>
                                                        @if ($opsi->image)
                                                            <img src="{{ asset('storage/' . $opsi->image) }}" alt="Gambar Opsi" class="img-thumbnail mb-2" style="max-width: 100px;">
                                                        @endif
                                                        <p><strong>Benar:</strong> {{ $opsi->is_correct ? 'Ya' : 'Tidak' }}</p>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('opsi.edit', $opsi->id_opsi) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <form action="{{ route('opsi.destroy', $opsi->id_opsi) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus opsi ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                        @else
                                            <p class="text-muted">Belum ada opsi untuk soal ini.</p>
                                        @endif

                                        <!-- Tambah Opsi -->
                                        <a href="{{ route('opsi.create', $item->id_soal) }}" class="btn btn-success btn-sm mt-3">Tambah Opsi</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                            <p class="text-muted">Belum ada soal untuk quiz ini.</p>
                        @endif

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('quiz.edit', $quiz->id_quiz) }}" class="btn btn-primary">Edit Quiz</a>
                            <a href="{{ route('soal.create', $quiz->id_quiz) }}" class="btn btn-success">Tambah Soal</a>
                            <form action="{{ route('quiz.destroy', $quiz->id_quiz) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus quiz ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus Quiz</button>
                            </form>
                            <a href="{{ route('admin.detailBuku.edit', $quiz->detailBuku->id_buku) }}" class="btn btn-warning"> Kembali</a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
