@extends('sewa_buku.layouts.userApp')

@section('title')
    Detail Bab
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h3>{{ $detailBuku->bab ?? 'Bab Tidak Ditemukan' }}</h3>
                </div>

                <div class="card-body">
                    <!-- Isi Bab -->
                    <div class="mb-4">
                        <h5 class="fw-bold">Isi Bab:</h5>
                        <p>{{ $detailBuku->isi ?? 'Isi tidak tersedia.' }}</p>
                    </div>

                    <!-- Audio Bab -->
                    @if (!empty($detailBuku->audio))
                        <div class="mb-4">
                            <h5 class="fw-bold">Audio Bab:</h5>
                            <audio controls class="w-100">
                                <source src="{{ asset('storage/' . $detailBuku->audio) }}" type="audio/mpeg">
                                Browser Anda tidak mendukung pemutar audio.
                            </audio>
                        </div>
                    @else
                        <div class="mb-4">
                            <h5 class="fw-bold">Audio Bab:</h5>
                            <p class="text-muted">Tidak ada audio untuk bab ini.</p>
                        </div>
                    @endif

                    <!-- Tombol Kembali -->
                    <div class="text-end mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
