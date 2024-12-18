@extends('sewa_buku.layouts.app')

@section('title')
    Detail Buku
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Daftar Buku</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $buku->judul_buku }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h1 class="display-6 mb-4">{{ $buku->judul_buku }}</h1>
        </div>
    </div>

    <div class="row">
        <!-- Cover Buku -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    @if($buku->coverBuku && $buku->coverBuku->count() > 0)
                        <div id="bookCoverCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($buku->coverBuku as $index => $coverBuku)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $coverBuku->file_image) }}"
                                             class="img-fluid rounded shadow-lg"
                                             alt="Cover Buku {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                            @if($buku->coverBuku->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#bookCoverCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#bookCoverCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <p class="text-muted">Cover tidak tersedia.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi Buku -->
        <div class="col-md-8 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informasi Buku</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Penulis:</dt>
                                <dd class="col-sm-8">{{ $buku->penulis }}</dd>

                                <dt class="col-sm-4">Penerbit:</dt>
                                <dd class="col-sm-8">{{ $buku->penerbit }}</dd>

                                <dt class="col-sm-4">ISBN:</dt>
                                <dd class="col-sm-8">{{ $buku->isbn }}</dd>

                                <dt class="col-sm-4">Tahun Terbit:</dt>
                                <dd class="col-sm-8">{{ $buku->tahun_terbit }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Rating:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-warning text-dark">
                                        {{ $buku->rating_amazon }} / 5
                                    </span>
                                </dd>

                                <dt class="col-sm-4">Link Pembelian:</dt>
                                <dd class="col-sm-8">
                                    <a href="{{ $buku->link_pembelian }}" target="_blank" class="text-primary">
                                        Beli Buku
                                    </a>
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <h6 class="mt-3">Tentang Penulis</h6>
                    <p class="text-muted">{{ $buku->tentang_penulis }}</p>

                    <h6 class="mt-3">Sinopsis</h6>
                    <p>{{ $buku->sinopsis }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Ringkasan dan Audio</h5>
                    <div class="row">
                        <div class="col-md-6">
                            @if ($buku->ringkasan_audio)
                            <h6>Ringkasan Audio</h6>
                            <audio controls class="w-100">
                                <source src="{{ asset('storage/' . $buku->ringkasan_audio) }}" type="audio/mpeg">
                                Browser Anda tidak mendukung pemutar audio.
                            </audio>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($buku->teaser_audio)
                                <div class="audio-container">
                                    <h6>Teaser Audio</h6>
                                    <audio controls class="w-100">
                                        <source src="{{ asset('storage/' . $buku->teaser_audio) }}" type="audio/mpeg">
                                        Browser Anda tidak mendukung pemutar audio.
                                    </audio>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Buku Bab -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detail Buku</h5>
                    <div class="accordion" id="detailBukuAccordion">
                        @forelse($buku->detailBuku as $index => $detail)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                        Bab: {{ $detail->bab }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#detailBukuAccordion">
                                    <div class="accordion-body">
                                        <p>{{ $detail->isi }}</p>
                                        @if($detail->audio)
                                            <div class="mt-2">
                                                <audio controls class="w-100">
                                                    <source src="{{ asset('storage/' . $detail->audio) }}" type="audio/mpeg">
                                                    Browser Anda tidak mendukung pemutar audio.
                                                </audio>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Detail buku tidak tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating dan Komentar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rating dan Komentar</h5>
                    @forelse($buku->rating as $rating)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="card-subtitle text-muted">{{ $rating->user->name }}</h6>
                                    <span class="badge bg-warning text-dark">
                                        {{ $rating->rating }} / 5
                                    </span>
                                </div>
                                <p class="card-text">{{ $rating->komentar }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada rating atau komentar untuk buku ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Buku -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quiz Buku</h5>
                    <div class="row">
                        @forelse($buku->detailBuku as $detail)
                            @if ($detail->quiz)
                                <div class="col-12 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <strong>{{ $detail->bab }}</strong> - {{ $detail->quiz->nama_quiz }}
                                            </h6>
                                            <p class="card-text text-muted">{{ $detail->quiz->deskripsi }}</p>
                                            @if($detail->quiz->file)
                                                <a href="{{ asset('storage/' . $detail->quiz->file) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                    Download Quiz
                                                </a>
                                            @endif

                                            <div class="mt-3">
                                                <h6>Soal:</h6>
                                                @forelse($detail->quiz->soal as $soal)
                                                    <div class="mb-3 border p-3 rounded">
                                                        <strong>{{ $loop->iteration }}. {{ $soal->soal }}</strong>
                                                        @if($soal->image)
                                                            <div class="mt-2">
                                                                <img src="{{ asset('storage/' . $soal->image) }}" alt="Soal Image" class="img-fluid">
                                                            </div>
                                                        @endif

                                                        <ul class="list-unstyled mt-2">
                                                            @foreach($soal->opsi as $opsi)
                                                                <li>
                                                                    <span>{{ $opsi->opsi }}</span>
                                                                    @if($opsi->is_correct)
                                                                        <span class="badge bg-success">Benar</span>
                                                                        @else
                                                                        <span class="badge bg-danger">Salah</span>
                                                                    @endif
                                                                    @if($opsi->image)
                                                                        <img src="{{ asset('storage/' . $opsi->image) }}" alt="Opsi Image" class="img-fluid" style="max-width: 50px;">
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @empty
                                                    <p class="text-muted">Belum ada soal untuk quiz ini.</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="col-12"><strong>{{ $detail->bab }}</strong> Quiz tidak tersedia untuk bab ini.</p>
                            @endif
                        @empty
                            <p class="col-12">Belum ada detail buku.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="row">
        <div class="col-12">
            <a href="{{ route('admin.buku.index') }}" class="btn btn-primary">
                Kembali ke Daftar Buku
            </a>
        </div>
    </div>
</div>
@endsection
