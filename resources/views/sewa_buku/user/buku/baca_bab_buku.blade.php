@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h3>{{ $detailBuku->bab ?? 'Ini Bab cokk'}}</h3>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h5>Isi Bab:</h5>
                <p>{{ $detailBuku->isi ?? 'Ini Isi cooo'}}</p>
            </div>

            @if ($detailBuku->audio ?? false)
                <div class="mb-4">
                    <h5>Audio Bab:</h5>
                    <audio controls>
                        <source src="{{ asset('storage/' . $detailBuku->audio) }}" type="audio/mpeg">
                        Browser Anda tidak mendukung pemutar audio.
                    </audio>
                </div>
            @else
                <span>Tidak ada audio</span>
            @endif


            <div class="mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
