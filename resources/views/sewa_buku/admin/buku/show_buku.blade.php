@extends('sewa_buku.layouts.app')

@section('title')
    Detail Buku
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">{{ $buku->nama_buku }}</h1>

    <!-- Sinopsis -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Sinopsis:</h2>
        <p class="text-gray-700">{{ $buku->sinopsis }}</p>
    </div>

    <!-- Full Cerita -->
    @if($buku->full_cerita)
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Full Cerita:</h2>
        <p class="text-gray-700">{{ $buku->full_cerita }}</p>
    </div>
    @endif

    <!-- Trailer -->
    @if($buku->trailer_voice)
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Trailer:</h2>
        <audio controls class="w-full">
            <source src="{{ asset('storage/' . $buku->trailer_voice) }}" type="audio/mp3">
            Browser Anda tidak mendukung pemutar audio.
        </audio>
    </div>
    @endif

    <!-- Full Voice -->
    @if($buku->full_voice)
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Full Voice:</h2>
        <audio controls class="w-full">
            <source src="{{ asset('storage/' . $buku->full_voice) }}" type="audio/mp3">
            Browser Anda tidak mendukung pemutar audio.
        </audio>
    </div>
    @endif

    <!-- Cover Buku -->
    <div class="mb-6">
        <h2 class="text-xl font-bold mb-4">Cover Buku:</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($buku->coverBuku as $cover)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('storage/' . $cover->file_image) }}" alt="{{ $buku->nama_buku }}" class="w-full h-48 object-cover">
            </div>
            @endforeach
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('admin.buku.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Kembali ke Daftar Buku
        </a>
    </div>
</div>
@endsection
